# Compatibility with Ant Media Server builds

Every REST call this package makes is checked against the endpoint list of a real server build.

| Date | Server | Result |
|---|---|---|
| 2026-10-27 | Enterprise 4.0.0-SNAPSHOT, build 20261022_0944 | All 50 calls in `src/Resources` exist with the same HTTP method, path and query parameter names. No code change needed. List: [`ams-rest-4.0.0-SNAPSHOT-20261022.txt`](ams-rest-4.0.0-SNAPSHOT-20261022.txt) |

## Checking a new server build

1. Unzip the server distribution (or use an installed server, `/usr/local/antmedia`).
2. Dump its endpoints (JDK 17 or newer):
   ```bash
   java tools/RestDump.java /path/to/ant-media-server /path/to/ant-media-server/webapps/LiveApp/WEB-INF/classes > docs/ams-rest-NEW.txt
   ```
3. Diff it with the previous list. For every removed or changed line, search `src/Resources` for that path and fix the call.
4. Add a row to the table above.
