import handlers from "./handlers/index.js";

import mul from "multer";
import express from "express";

let multer = mul({});

export default async function routes(app) {
  // ping
  app.get("/", (req, res) => {
    res.send("Api is up!");
  });

  // email routes
  app.post("/emails", multer.any(), handlers.emailhandler.sendEmail);
  app.post("/emails/debug", multer.any(), handlers.emailhandler.sendEmailDebug);
}
