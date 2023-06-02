#include <ArduinoJson.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <string.h>
#include <ArduinoJson.h>
WiFiClient client;
WiFiServer server(80);
const char* ssid = "NodeMCU"; // Enter SSID here
const char* password = ""; //Enter Password here
String NETSSID = "";         
String NETPASSWD = "";    
String val1 = " ";    
#include <SoftwareSerial.h>
SoftwareSerial arduinoSerial(3, 2);  // RX, TX pins on ESP8266 // d4 to transmit
    int count = 0;
void setup()
{   
    arduinoSerial.begin(9600);  // Initialize software serial communication with Arduino
Serial.begin(9600);
IPAddress local_ip(192,168,1,1);
IPAddress gateway(192,168,1,1);
IPAddress subnet(255,255,255,0);
Serial.println("NodeMCU Started!");
WiFi.softAP(ssid, password);
WiFi.softAPConfig(local_ip, gateway, subnet);
delay(100);

server.begin();
}

void loop()
{

//String message = "Hello from ESP8266!";
 // arduinoSerial.println(message);
//delay(1000);

client = server.available(); //Gets a client that is connected to the server and has data available for reading.
if (client == 1)
{
  String request = client.readStringUntil('\n');
  if(request == "192.168.0.103/logout"){
  logout();
  }
  else{

    Serial.println("request:" + request);
    int firstSlash = request.indexOf('/');
    int secondSlash = request.indexOf('/', firstSlash+1);
    int thirdSlash = request.indexOf('/', secondSlash+1);
    int fourthslash = request.indexOf('/', thirdSlash+1);
    int spaceindex = request.indexOf(' ', fourthslash+1);
     val1 = request.substring(firstSlash+1, secondSlash);
    String val2 = request.substring(secondSlash+1, thirdSlash);
    String val3 = request.substring(thirdSlash+1, fourthslash);
    String val4 = request.substring(fourthslash+1, spaceindex);
    //Serial.println("val1: " + val1);
   // Serial.println("val2: " + val2);
   // Serial.println("val3: " + val3);
   // Serial.println("val4: " + val4);
    NETSSID = val2;
    NETPASSWD = val3;
    request.trim();
   retreiveData(); 

  }
}
if(count >0){
  retreiveData(); 
}

if(NETSSID!=NULL && NETPASSWD!= NULL){
 // serverFunction();

}
}

void serverFunction(){
    Serial.begin(115200);
  //Serial.setDebugOutput(true);

  Serial.println();
  Serial.println();
  Serial.println();

  //Connect to Wi-Fi
  WiFi.mode(WIFI_STA);
  WiFi.begin(NETSSID, NETPASSWD);
  Serial.print("Connecting to WiFi ..");
  int count = 0;
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print('.');
    delay(1000);
    count++;
    if(count>15) break;
    
  }

  if ((WiFi.status() == WL_CONNECTED)) {
    std::unique_ptr<BearSSL::WiFiClientSecure>client(new BearSSL::WiFiClientSecure);
    // Ignore SSL certificate validation
    client->setInsecure();
    HTTPClient https;
    Serial.print("[HTTPS] begin...\n");
    if (https.begin(*client, "https://automated-pill-dispenser.000webhostapp.com/signup.php?uname=user5&passwd=123&passwd=1234")) {  // HTTPS
      Serial.print("[HTTPS] GET...\n");
      // start connection and send HTTP header
      int httpCode = https.GET();
      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
        Serial.printf("[HTTPS] GET... code: %d\n", httpCode);
        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = https.getString();
          Serial.println(payload);
        }
      } else {
        Serial.printf("[HTTPS] GET... failed, error: %s\n", https.errorToString(httpCode).c_str());
      }

      https.end();
    } else {
      Serial.printf("[HTTPS] Unable to connect\n");
    }
  }
  Serial.println();
  Serial.println("Waiting 10s before the next round...");
  delay(10000);
}
void retreiveData(){
   Serial.begin(9600);
  Serial.println();
  Serial.println();
  Serial.println();
  //Connect to Wi-Fi
  WiFi.mode(WIFI_STA);
  WiFi.begin(NETSSID, NETPASSWD);
  Serial.print("Connecting to WiFi ..");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print('.');
    delay(1000);
  }
  //Serial.println("Your IP is");

//Serial.println((WiFi.localIP().toString()));
  // Make HTTP request to PHP file on web server
  std::unique_ptr<BearSSL::WiFiClientSecure>client(new BearSSL::WiFiClientSecure);
    // Ignore SSL certificate validation
    client->setInsecure();
    HTTPClient https;
  https.begin(*client,"https://automated-pill-dispenser.000webhostapp.com/api2.php?pFName=" +val1 );
  int httpCode = https.GET();
  String payload = https.getString();
  DynamicJsonDocument doc(300);
  deserializeJson(doc, payload);

  // Access JSON array elements
    for (JsonObject obj : doc.as<JsonArray>()) {
    String name = obj["pFName"];
    String pill1 = obj["pill1"];
    String pill2 = obj["pill2"];
    String pill3 = obj["pill3"];
    String pill4 = obj["pill4"];
  //Serial.print("pFName: ");
   // Serial.print(name);
   // Serial.print(", pill1: ");
 // Serial.print(pill1);
   //   Serial.print(", pill2: ");
  // Serial.print(pill2);
//Serial.print(", pill3: ");
  //  Serial.print(pill3);
//Serial.print(", pill4: ");
  // Serial.print(pill4);
arduinoSerial.print(pill1 + "+");
arduinoSerial.print(pill2+ "+");
arduinoSerial.print(pill3+ "+");
arduinoSerial.print(pill4+ "+");
arduinoSerial.print("\n");

count++;
delay(1000);
  }
}
void logout(){
Serial.println("logged out");
}
