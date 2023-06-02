import EmailService from "../../src/services/email_service";
import httpcode from "http-status-codes";
const emailService = new EmailService();

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
});
