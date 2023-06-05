import mongoose from "mongoose";
import config from "../../config/index.js";

const connectDB = async () => {
  try {
    await mongoose.connect(config.mongoURL);
    // mongoose.set("debug", true);
    // TODO: Logger
    console.log("Connected to the database (mongodb)");
  } catch (error) {
    // TODO: Logger
    console.error("Failed to connect to the database (mongodb):", error);
  }
};

export default { connectDB };
