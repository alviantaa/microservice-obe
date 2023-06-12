import { PactV3 } from "@pact-foundation/pact";
import { MatchersV3 } from "@pact-foundation/pact";
import httpcode from "http-status-codes";
import axios from "axios";

const { like } = MatchersV3;
const Pact = PactV3;

const mockProvider = new Pact({
  consumer: "email-service-siobe",
  provider: "user-service-siobe",
  // names should be in config (probably)
});

describe("User Service API pact test", () => {
  describe("getting user role", () => {
    it("user with ID 1 exists, and is an admin", () => {
      const expectedResponse = {
        role: "admin",
      };

      mockProvider
        .given("user with ID 1 exists and is an admin")
        .uponReceiving("a request to get a user's role")
        .withRequest({
          method: "GET",
          path: "/users/role/1",
        })
        .willRespondWith({
          status: httpcode.OK,
          headers: {
            "Content-Type": "application/json; charset=utf-8",
          },
          body: like(expectedResponse),
        });

      return mockProvider.executeTest(async (mockserver) => {
        // i think the best way to make api calls is to make a seperate class in a file
        // tapi karena test ini satu aja, jadi...
        const response = await axios.get(mockserver.url + "/users/role/1");

        expect(response.status).toBe(httpcode.OK);
        expect(response.data).toMatchObject(expectedResponse);
        return;
      });
    });

    it("user does not exists", () => {
      mockProvider
        .given("user with id 999 does not exists")
        .uponReceiving("a request to get a user's role")
        .withRequest({
          method: "GET",
          path: "/users/role/999",
        })
        .willRespondWith({
          status: httpcode.NOT_FOUND,
        });

      return mockProvider.executeTest(async (mockserver) => {
        try {
          await axios.get(mockserver.url + "/users/role/999");
        } catch (err) {
          expect(err.response.status).toBe(httpcode.NOT_FOUND);
        }
        return;
      });
    });
  });
});
