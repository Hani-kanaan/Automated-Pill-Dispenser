
#define NUM_PILLS 4
#include <Servo.h>
#include <LiquidCrystal_I2C.h>
#include <Stepper.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);
int selectButton = 16 ;
int incButton = 15 ;
int minButton = 14;
int count = 0 ;

#include <virtuabotixRTC.h>                                                                              
virtuabotixRTC myRTC(6, 7, 5); // CLK , DATA , RST

Servo myservo; 
#define ledPin 7 //test for bluetooth
int state = 0; // state for led 

const int stepsPerRevolution = 2048;  // change this to fit the number of steps per revolution
Stepper myStepper(stepsPerRevolution, 8, 9, 10, 11);
int currentHour;

  struct pill{
  char name[20];
  int hour;
  int min;// means 1 byte
  int stepperPos; 
};
struct pill pills[NUM_PILLS] = {
    {"pill 1" , 8 , 00 , 1},
    {"pill 2" , 9 , 45 , 2},
    {"pill 3" , 10 , 15 , 3},
};




void setup() {
  myStepper.setSpeed(10);
Serial.begin(9600);
pinMode(ledPin, OUTPUT);
digitalWrite(ledPin, LOW);
lcd.setCursor(0, 0);

pinMode(selectButton, INPUT);
pinMode(incButton, INPUT);
pinMode(minButton, INPUT);

lcd.begin();
lcd.backlight();
myRTC.setDS1302Time(40, 01, 12, 5,15, 4, 2023);//but remember to "comment/remove" this function once you're done as I did
 //The setup is done only one time and the module will continue counting it automatically
 

myservo.attach(3);

}

void loop() {
//myStepper.step(stepsPerRevolution);
//delay(500);

 lcd.setCursor(0, 0);
  
 int buttonState1 = digitalRead(selectButton);
 int buttonState2 = digitalRead(incButton);
int buttonState3 = digitalRead(minButton);


if (buttonState1 == HIGH) {
    lcd.clear();

count++; //connect this pin to avoid infinite loop
if(count == 3){
  count = 0;
}}

if(buttonState2 == HIGH){
    lcd.clear();

  pills[count].hour++;
  if(pills[count].hour > 23){
    pills[count].hour= 0 ;
  }}
 


  if(buttonState3 == HIGH){
      lcd.clear();
  pills[count].min = pills[count].min+15 ;
  if(pills[count].min > 45){
    pills[count].min= 0 ;
  }
}
lcd.print(pills[count].name);
lcd.print(" ");
lcd.print(pills[count].hour);
lcd.print(":");
lcd.print(pills[count].min);
delay(100);

 if(Serial.available() > 0){ // Checks whether data is coming from the serial port
  //  state = Serial.read(); // Reads the data from the serial port
 String input =  Serial.readStringUntil('\n'); // Read the input string until newline character
 char *idx_str = strtok(input.c_str(), " ");
char *hour_str = strtok(NULL, " "); // Split the input string into Hour and Minute using space delimiter
char *min_str = strtok(NULL, " ");
//if(hour_str != NULL && min_str != NULL){

   int idx = atoi(idx_str);
  int hour = atoi(hour_str); // Convert the Hour string into integer
  int min = atoi(min_str); // Convert the Minute string into integer
  pills[idx].hour = hour; // Assign the Hour value to pills structure
  pills[idx].min = min; // Assign the Minute value to pills structure
   Serial.println(idx);
  Serial.println(hour);
Serial.println(min);

//}
  
 }

 if (state == '0') {
  digitalWrite(ledPin, LOW); // Turn LED OFF
  Serial.println("LED: OFF"); // Send back, to the phone, the String "LED: ON"
  state = 0;
 }
 else if (state == '1') {
  digitalWrite(ledPin, HIGH);
  Serial.println("LED: ON");
  state = 0;
 } 

  myRTC.updateTime();
 lcd.setCursor(0,1);
 lcd.print(myRTC.hours);
 lcd.print(":");
 lcd.print(myRTC.minutes);
 lcd.print(":");
 lcd.print(myRTC.seconds);
 delay(1000);
lcd.clear();
for(int i=0 ; i<3 ; i++){
  if(myRTC.hours == pills[i].hour && myRTC.minutes == pills[i].min &&myRTC.seconds == 0){
    // myStepper.step(pills[i].stepperPos);
    // delay(500);
      myservo.write(90);
      delay(15);
      Serial.println("servo 90");
      myservo.write(0);
      delay(15);
       Serial.println("servo 0");
     // myStepper.step(-pills[i].stepperPos);
  }
}

}


