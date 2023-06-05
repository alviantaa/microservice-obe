// see https://github.com/motdotla/dotenv#how-do-i-use-dotenv-with-import
import * as dotenv from "dotenv";

dotenv.config();

// const env = process.env.NODE_ENV;

// if (!(env === "test" || env === "production" || env === "development")) {
//   console.log(process.env.appName + ": Wrong app env value?");
//   process.exit(0);
// }

export default {
  appName: process.env.APP_NAME,
  port: process.env.PORT,

  mongoURL: process.env.MONGO_URL,

  mailFrom0: process.env.MAIL_FROM_0,

  mailHost: process.env.MAIL_HOST,
  mailPort: process.env.MAIL_PORT,
  mailUsername: process.env.MAIL_USERNAME,
  mailPassword: process.env.MAIL_PASSWORD,
};
