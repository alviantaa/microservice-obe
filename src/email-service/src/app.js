import createServer from "./server.js";
import mongo from "./db/mongo/conn.js";
import config from "./config/index.js";

// connection to db
await mongo.connectDB();

const app = createServer();
const port = config.port || 8080;
app.listen(port, () => {
  // TODO: Logger
  console.info("Server is running on " + port);
});
