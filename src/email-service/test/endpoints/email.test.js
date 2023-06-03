import supertest from "supertest";
import httpcode from "http-status-codes";

import mockemailrepo from "../__mocks__/email_repository.js";
import * as constants from "../../src/constants/index.js";
import createServer from "../../src/server.js";

const app = createServer();

// mocking repo module
jest.mock("../../src/repositories/email_repository.js", () => ({
  ...jest.requireActual("../../src/repositories/email_repository.js"),
  getById: mockemailrepo.getById,
  create: mockemailrepo.create,
}));

describe("email endpoint test", () => {
  describe("POST /emails (send email endpoint)", () => {
    it("should return 400 (required field is not defined)", async () => {
      // to and subject field is not defined.
      const res = await supertest(app)
        .post("/emails")
        .field("from", "test@example.com")
        .attach("attachments", null)
        .expect(httpcode.BAD_REQUEST);
      expect(res.body.status).toBe(constants.STATUS_FAIL);
    });

    it("should send email successfully", async () => {
      const res = await supertest(app)
        .post("/emails")
        .field("from", "test@example.com")
        .field("to", ["to1@gmail.com", "to2@gmail.com"])
        .field("subject", "this is email subject")
        .field("html", "html_")
        .field("text", "text_")
        .expect(httpcode.OK);

      expect(res.body.status).toBe(constants.STATUS_SUCCESS);
      expect(res.body.data != null).toBe(true);
    }, 10000);
  });

  describe("POST /emails/debug debug email template endpoint", () => {
    it("should compile template successfully", async () => {
      const res = await supertest(app)
        .post("/emails/debug")
        .field("from", "test@example.com")
        .field("to", ["to1@gmail.com", "to2@gmail.com"])
        .field("subject", "this is email subject")
        .field("html", "hi my name is <name>{{name}}</name>!")
        .field("text", "hi my name is {{name}}!")
        .field(
          "data",
          JSON.stringify({
            name: "dnabil",
          })
        );

      expect(res.body.data.email.html).toContain("dnabil");
      expect(res.body.data.email.text).toContain("dnabil");
    });

    it("should 400 when passed wrong 'data'", async () => {
      const res = await supertest(app)
        .post("/emails/debug")
        .field("from", "test@example.com")
        .field("to", ["to1@gmail.com", "to2@gmail.com"])
        .field("subject", "this is email subject")
        .field("html", "hi my name is <name>{{name}}</name>!")
        .field("text", "hi my name is {{name}}!")
        .field("data", "name: dnabil")
        .expect(httpcode.BAD_REQUEST);

      expect(res.body.status).toBe(constants.STATUS_FAIL);
    });
  });
});
