import java.io.File;
import java.lang.annotation.Annotation;
import java.lang.reflect.Method;
import java.net.URL;
import java.net.URLClassLoader;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;
import java.util.TreeSet;
import java.util.jar.JarEntry;
import java.util.jar.JarFile;

/**
 * Prints every REST endpoint (HTTP method, path relative to /{app}/rest, query parameters) of an
 * Ant Media Server build, read from the server's own jars. Used to check this package against a
 * new server build; see docs/compatibility.md.
 *
 * Usage (JDK 17+): java tools/RestDump.java /path/to/ant-media-server /path/to/ant-media-server/webapps/LiveApp/WEB-INF/classes
 */
public class RestDump {
	public static void main(String[] args) throws Exception {
		String amsDir = args[0];
		List<URL> urls = new ArrayList<>();
		urls.add(new File(amsDir, "ant-media-server.jar").toURI().toURL());
		for (String sub : new String[] {"lib", "plugins"}) {
			File[] files = new File(amsDir, sub).listFiles((d, n) -> n.endsWith(".jar"));
			if (files != null) for (File f : files) urls.add(f.toURI().toURL());
		}
		File war = new File(args[1]); // exploded WEB-INF/classes of StreamApp
		urls.add(war.toURI().toURL());
		URLClassLoader cl = new URLClassLoader(urls.toArray(new URL[0]), RestDump.class.getClassLoader());

		List<String> classes = new ArrayList<>();
		for (URL u : urls) {
			File f = new File(u.toURI());
			if (f.isDirectory()) { collect(f, f, classes); continue; }
			if (!f.getName().startsWith("ant-media")) continue;
			try (JarFile jf = new JarFile(f)) {
				for (Enumeration<JarEntry> e = jf.entries(); e.hasMoreElements();) {
					String n = e.nextElement().getName();
					if (n.contains("/rest/") && n.endsWith(".class") && !n.contains("$")) classes.add(n);
				}
			}
		}
		TreeSet<String> out = new TreeSet<>();
		for (String n : classes) {
			String cn = n.replace('/', '.').replace(".class", "");
			Class<?> c;
			try { c = Class.forName(cn, false, cl); } catch (Throwable t) { continue; }
			String base = path(c.getAnnotations());
			if (base == null) continue;
			Method[] ms;
			try { ms = c.getDeclaredMethods(); } catch (Throwable t) { out.add("?    " + base + "   (" + cn + ": " + t + ")"); continue; }
			for (Method m : ms) {
				Annotation[] as;
				try { as = m.getAnnotations(); } catch (Throwable t) { continue; }
				String verb = null, p = "";
				for (Annotation a : as) {
					String an = a.annotationType().getSimpleName();
					if (an.matches("GET|POST|PUT|DELETE|PATCH")) verb = an;
					if (an.equals("Path")) p = value(a);
				}
				StringBuilder q = new StringBuilder();
				try {
					for (Annotation[] pa : m.getParameterAnnotations())
						for (Annotation a : pa)
							if (a.annotationType().getSimpleName().equals("QueryParam")) q.append(q.length() == 0 ? "  ?" : ",").append(value(a));
				} catch (Throwable t) { q.append("  ?(params unreadable)"); }
				if (verb != null) out.add(String.format("%-6s %s%s%s", verb, base, p.isEmpty() ? "" : (p.startsWith("/") ? p : "/" + p), q));
			}
		}
		out.forEach(System.out::println);
	}

	static void collect(File root, File dir, List<String> classes) {
		File[] fs = dir.listFiles();
		if (fs == null) return;
		for (File f : fs) {
			if (f.isDirectory()) collect(root, f, classes);
			else {
				String rel = root.toURI().relativize(f.toURI()).getPath();
				if (rel.contains("/rest/") && rel.endsWith(".class") && !rel.contains("$")) classes.add(rel);
			}
		}
	}

	static String path(Annotation[] as) {
		for (Annotation a : as) if (a.annotationType().getSimpleName().equals("Path")) return value(a);
		return null;
	}

	static String value(Annotation a) {
		try { return (String) a.annotationType().getMethod("value").invoke(a); } catch (Exception e) { return "?"; }
	}
}
