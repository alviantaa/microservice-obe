import express from "express";
import routes from "./routes.js";

export default function createServer() {
  const app = express();
  routes(app);
  return app;
}
