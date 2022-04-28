#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#include "DHT.h"
#include "config.h"

// https://gist.github.com/Matheus-Garbelini/2cd780aed2eddbe17eb4adb5eca42bd6#comments
extern "C" {
#include "user_interface.h"
#include "wpa2_enterprise.h"
#include "c_types.h"
}

// Initialize DHT sensor.
DHT dht(DHTPin, DHTTYPE);

float Temperature;
float Humidity;

// https://randomnerdtutorials.com/esp8266-nodemcu-http-get-post-arduino/
//Your Domain name with URL path or IP address with path
String serverName = SERVER_BASE;


// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Set timer to 5 seconds (5000)
unsigned long timerDelay = 5000;


void setup() {
    Serial.begin(115200);
    delay(100);

    pinMode(DHTPin, INPUT);
    dht.begin();

    Serial.println();
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(WIFI_SSID);

    WiFi.begin(WIFI_SSID, WIFI_PASS);

    //check wi-fi is connected to wi-fi network
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.print(".");
    }
    Serial.println("");
    Serial.println("WiFi connected");
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());

}

void loop() {
 if ((millis() - lastTime) > timerDelay) {
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED)
  {
    Temperature = dht.readTemperature(); // Gets the values of the temperature
    Humidity = dht.readHumidity(); // Gets the values of the humidity

    WiFiClient client;
    HTTPClient http;

    Serial.println("Temp: " + String(Temperature));
    Serial.println("Humi: " + String(Humidity));
  
    Serial.println("Sending data now!");

    // HTTP Client with GET
    String fullHTTP = String(SERVER_BASE) + "?id=" + String(WiFi.macAddress()) + "&temperature=" + String(Temperature) + "&humidity=" + String(Humidity);

    Serial.println(fullHTTP);

    http.begin(client, fullHTTP.c_str());
      
    // Send HTTP GET request
    int httpResponseCode = http.GET();
      
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      String payload = http.getString();
      Serial.println(payload);
     }
     else {
       Serial.print("Error code: ");
       Serial.println(httpResponseCode);
     }
    http.end();
   }
   else 
   {
    Serial.println("WiFi Disconnected");
   }
    lastTime = millis();
  }
}
