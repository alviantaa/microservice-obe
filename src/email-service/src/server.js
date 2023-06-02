import express from "express";
import config from "./config/index.js";
import routes from "./routes.js";

const app = express();

routes(app);

const port = config.port || 8080;
app.listen(port, () => {
  // TODO: Logger
  console.info("Server is running on " + port);
});
