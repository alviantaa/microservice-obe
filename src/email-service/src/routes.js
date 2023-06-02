import mul from "multer";
import express from "express";
let multer = mul({});

export default async function routes(app) {
  // ping
  app.get("/", (req, res) => {
    res.send("Api is up!");
  });
}
