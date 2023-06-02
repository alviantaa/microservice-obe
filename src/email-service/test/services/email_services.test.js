import httpcode from "http-status-codes";
import mongoose from "mongoose";

import * as mockConstants from "../../src/constants/index.js"; // tanpa 'mock'.. bakal error?
import emailrepo from "../../src/repositories/email_repository.js";
import EmailService from "../../src/services/email_service";
import mockEntities from "../../src/db/mongo/entities/index.js"; // tanpa 'mock'.. bakal error?

// mocking repo module
jest.mock("../../src/repositories/email_repository.js", () => ({
  ...jest.requireActual("../../src/repositories/email_repository.js"),

  getById: (id) => {
    // list of emails (array)
    let emailList = [
      new mockEntities.Email({
        to: ["test@gmail.com"],
        cc: [],
        bcc: [],
        subject: [],
        from: ["from@gmail.com"],
        text: "hi from test!",
        status: mockConstants.EMAIL_STATUS_NOT_SENT,
        createdAt: Date.now(),
        _id: "617cfa4c9e3f7a001f9a63fd",
      }),
    ];

    // search through array
    for (const element of emailList) {
      if (element._id.toString() === id) {
        return Promise.resolve(element);
      }
    }
    return Promise.resolve(null);
  },
}));

const emailService = new EmailService(emailrepo);

describe("email service", () => {
  describe("compileTemplate(template, data)", () => {
    it("should be compiled successfuly", () => {
      const template = "{{f_name}} {{l_name}}";
      const data = {
        f_name: "daffa",
        l_name: "nabil",
      };
      expect(emailService.compileTemplate(template, data)).toBe("daffa nabil");
    });

    it("should throw a bad request error", () => {
      const template = "{{f_name}}";
      const data = 123;
      try {
        emailService.compileTemplate(template, data);
      } catch (error) {
        expect(error.code).toBe(httpcode.BAD_REQUEST);
      }
    });
  });

  describe("getById(id)", () => {
    it("should find email", async () => {
      const email = await emailService.getById("617cfa4c9e3f7a001f9a63fd");
      expect(email != null).toBe(true);
    });

    it("should not find email, 404", async () => {
      try {
        await emailService.getById("aaaaaa4c9e3f7a001f9awwww");
      } catch (error) {
        expect(error.code).toBe(httpcode.NOT_FOUND);
      }
    });
  });
});
