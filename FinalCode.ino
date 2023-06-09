
#define NUM_PILLS 4
#include <Servo.h>
#include <LiquidCrystal_I2C.h>
#include <Stepper.h>
#include <EEPROM.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);
int count = 0 ;
int counter =0;

#include <virtuabotixRTC.h>                                                                              
virtuabotixRTC myRTC(6, 7, 5); // CLK , DATA , RST

Servo myservo; 
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
    {"pill 1" , 8 , 00 , 100},
    {"pill 2" , 9 , 45 , 300},
    {"pill 3" , 10 , 15 , 800},
    {"pill 4" , 10 , 15 , 1200},
};



int buttonState = 0;     // current state of the button
int lastButtonState = 0; // previous state of the button
int startPressed = 0;    // the moment the button was pressed
int endPressed = 0;      // the moment the button was released
int holdTime = 0;        // how long the button was hold
int idleTime = 0;        // how long the button was idle


#include <LiquidCrystal_I2C.h>

// Defines the pins that will be used for the display

//bitmap array for the dino character
byte dino [8]
{ B00000,
  B00111,
  B00101,
  B10111,
  B11100,
  B11111,
  B01101,
  B01100,
};

//character for the tree
byte tree [8]
{
  B00011,
  B11011,
  B11011,
  B11011,
  B11011,
  B11111,
  B01110,
  B01110
};
const int buttonPin = 16;  
const int BUTTON_ENTER = 14; // minbutton
const int BUTTON_SELECT = 15; // incbutton
int f =0;
const int MENU_SIZE = 2;
const int LCD_COLUMN = 16;

const int TREE_CHAR = 6;
const int DINO_CHAR = 7;

const String ALPHABET[26] = { "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z" };

boolean isPlaying = false;
boolean isShowScore = false;
boolean isDinoOnGround = true;

int currentIndexMenu = 0;
int score = 0;
int scoreListSize = 0;
String scoreList[20];


void setup() {
    myStepper.setSpeed(10);

pinMode(BUTTON_SELECT, INPUT);
pinMode(BUTTON_ENTER, INPUT);
lcd.begin();
lcd.backlight();
myRTC.setDS1302Time(40, 01, 12, 5,15, 4, 2023);//but remember to "comment/remove" this function once you're done as I did
myservo.attach(3);
//pills[0] = EEPROM.get(int idx, T &t)
pill custom; //Variable to store custom object read from EEPROM.
for (int i = 0 ; i<4 ; i++){
/*EEPROM.get(i, custom );
//Serial.println( custom.name );
 // Serial.println( custom.hour );
 // Serial.println( custom.min );
  int hour= custom.hour;
  int min = custom.min;
  String name = custom.name;
  //pills[i].name = name;
  pills[i].hour =hour;
  pills[i].min = min;*/
  
}
  pinMode(buttonPin, INPUT); // initialize the button pin as a input
  Serial.begin(9600);        // initialize serial communication
  lcd.setCursor(16, 2);
  lcd.begin();
  lcd.createChar(DINO_CHAR, dino);
  lcd.createChar(TREE_CHAR, tree);
}

void loop() {
    lcd.clear();
  buttonState = digitalRead(buttonPin); // read the button input

  if (buttonState != lastButtonState) { // button state changed
     updateState();
    
  }
  lastButtonState = buttonState;        // save state for next loop
   if(f>>0){
   
 //    handleMenu();
    
  }
  if (f ==0){
    ACTION();
  }
  
}

void updateState() {
  // the button has been just pressed
  if (buttonState == HIGH) {
      startPressed = millis();
      idleTime = startPressed - endPressed;


  } else {
      endPressed = millis();
      holdTime = endPressed - startPressed;

      if (holdTime >= 500 && holdTime < 1000) {
        //  Serial.println("Button was held for half a second"); 
      }

      if (holdTime >= 1000) {
       //   Serial.println("Button was held for one second or more"); 
        f++;
      }

  }
}
void handleMenu() {
  String menu[MENU_SIZE] = { "START", "SCORE" };

  for (int i = 0; i < MENU_SIZE; i++) {
    if (i == currentIndexMenu) {
      lcd.setCursor(0, i);
      lcd.print("-> ");
    
    }

    lcd.setCursor(3, i);
    lcd.print(menu[i]);
  }

  if (digitalRead(BUTTON_SELECT) == HIGH) {
    currentIndexMenu = currentIndexMenu == 0 ? 1 : 0;
  }

  if (digitalRead(BUTTON_ENTER) == HIGH) {
    currentIndexMenu == 0 ? startGame() : showScore();
  }
  delay(100);
}

void showScore () {
  isShowScore = true;
  delay(200);

  int currentIndex = 0;
  const int lastIndex = scoreListSize - 1;

  printScore(currentIndex, lastIndex);

  while (isShowScore) {
    if (digitalRead(BUTTON_SELECT) == HIGH) {
      currentIndex = currentIndex < lastIndex ? currentIndex + 1 : 0;
      printScore(currentIndex, lastIndex);
    }

    if (digitalRead(BUTTON_ENTER) == HIGH) {
      isShowScore = false;
    }

    delay(200);
  }
}

void printScore(int index, int lastIndex) {
  lcd.clear();

  if (lastIndex == -1) {
    lcd.print("NO SCORE");
  }
  else {
    lcd.print(scoreList[index]);

    if (index < lastIndex) {
      lcd.setCursor(0, 1);
      lcd.print(scoreList[index + 1]);
    }
  }
}

void startGame () {
  isPlaying = true;

  while (isPlaying) {
    handleGame();
  }
}

void handleGame() {
  lcd.clear();
  if(digitalRead(BUTTON_SELECT) == HIGH){
      handleGameOver();
  }
  int buttonPressedTimes = 0;

  // Generate two random distances for the space between the trees
  int secondPosition = random(4, 9);
  int thirdPosition = random(4, 9);
  int firstTreePosition = LCD_COLUMN;

  const int columnValueToStopMoveTrees = -(secondPosition + thirdPosition);

  // this loop is to make the trees move, this loop waiting until
  // all the trees moved
  for (; firstTreePosition >= columnValueToStopMoveTrees; firstTreePosition--) {

    lcd.setCursor(13, 0);
    lcd.print(score);

    defineDinoPosition();

    int secondTreePosition = firstTreePosition + secondPosition;
    int thirdTreePosition = secondTreePosition + thirdPosition;

    showTree(firstTreePosition);
    showTree(secondTreePosition);
    showTree(thirdTreePosition);

    if (isDinoOnGround) {
      if (firstTreePosition == 1 || secondTreePosition == 1 || thirdTreePosition == 1  || digitalRead(BUTTON_SELECT) == HIGH) {
        handleGameOver();
        delay(5000);
        break;
      }
      buttonPressedTimes = 0;

    } else {
      if (buttonPressedTimes > 3) {
        score -= 3;
      }

      buttonPressedTimes++;
    }

    score++;
    delay(500);
  }
  lcd.clear();
}

void handleGameOver () {
  lcd.clear();
  lcd.print("GAME OVER");

  lcd.setCursor(0, 1);
  lcd.print("SCORE: ");
  lcd.print(score);

  delay(1000);
  saveScore();
  lcd.clear();
  
}

void saveScore () {
  lcd.clear();

  String nick = "";
  int nameSize = 0;
  int alphabetCurrentIndex = 0;

  lcd.print("TYPE YOUR NAME");

  while (nameSize != 3) {
    lcd.setCursor(nameSize, 1);
    lcd.print(ALPHABET[alphabetCurrentIndex]);

    if (digitalRead(BUTTON_SELECT) == HIGH) {
      alphabetCurrentIndex = alphabetCurrentIndex != 25 ? alphabetCurrentIndex + 1 : 0;
    }

    if (digitalRead(BUTTON_ENTER) == HIGH) {
      nick += ALPHABET[alphabetCurrentIndex];

      nameSize++;
      alphabetCurrentIndex = 0;
    }

    delay(300);
    f = 0;
  }

  scoreList[scoreListSize] =  nick + " " + score;
  scoreListSize++;

  isPlaying = false;
  score = 0;
  lcd.clear();
}

void showTree (int position) {
  lcd.setCursor(position, 1);
  lcd.write(TREE_CHAR);

  // clean the previous position
  lcd.setCursor(position + 1, 1);
  lcd.print(" ");
}

void defineDinoPosition () {
  int buttonState = digitalRead(BUTTON_ENTER);
  buttonState == LOW ? putDinoOnGround() : putDinoOnAir();
}

void putDinoOnGround () {
  lcd.setCursor(1, 1);
  lcd.write(DINO_CHAR);
  lcd.setCursor(1, 0);
  lcd.print(" ");

  isDinoOnGround = true;
}

void putDinoOnAir () {
  lcd.setCursor(1, 0);
  lcd.write(DINO_CHAR);
  lcd.setCursor(1, 1);
  lcd.print(" ");

  isDinoOnGround = false;
}
void ACTION() {

  lcd.setCursor(0, 0);

  int buttonState1 = digitalRead(buttonPin);
  int buttonState2 = digitalRead(BUTTON_SELECT);
  int buttonState3 = digitalRead(BUTTON_ENTER);

  if (buttonState1 == HIGH) {
    lcd.clear();
    count++; // connect this pin to avoid infinite loop
  }

  if (count == 3) {
    count = 0;
  }

  if (buttonState2 == HIGH) {
    lcd.clear();
    pills[count].hour++;
    if (pills[count].hour > 23) {
      pills[count].hour = 0;
    }
  }

  if (buttonState3 == HIGH) {
    lcd.clear();
    pills[count].min = pills[count].min + 15;
    if (pills[count].min > 45) {
      pills[count].min = 0;
    }
  }

  lcd.print(pills[count].name);
  lcd.print(" ");
  lcd.print(pills[count].hour);
  lcd.print(":");
  lcd.print(pills[count].min);
  delay(100);
  
  if (Serial.available()) {
    
    String data = Serial.readStringUntil('\n');
  
    char input[data.length() + 1];
    strcpy(input, data.c_str());
  
    char* token = strtok(input, "+");
  
  while (token != NULL) {
  // Extract hours and minutes from the token
  int hour, min;
  sscanf(token, "%d:%d", &hour, &min);

  // Update pill values
  if(counter <4){
    pills[counter].hour = hour;
    pills[counter].min = min;
  

  }
  
  // Print the extracted values
//  Serial.print("Hours: ");
//  Serial.print(hour);
 // Serial.print(", Minutes: ");
 // Serial.println(min);
  
  token = strtok(NULL, "+");
  counter++;
}
counter = 0;
// Print updated pill information
for (int i = 0; i < 4 ; i++) {


}

  
 
  }

  // char *idx_str = strtok(input.c_str(), " ");
  // char *hour_str = strtok(NULL, " "); // Split the input string into Hour and Minute using space delimiter
  // char *min_str = strtok(NULL, " ");
  // if(hour_str != NULL && min_str != NULL){

  //   int idx = atoi(idx_str);
  //   int hour = atoi(hour_str); // Convert the Hour string into integer
  //   int min = atoi(min_str); // Convert the Minute string into integer
  //   pills[idx].hour = hour; // Assign the Hour value to pills structure
  //   pills[idx].min = min; // Assign the Minute value to pills structure
  //   EEPROM.put(idx, pills[idx] );

  // }

  myRTC.updateTime();
  lcd.setCursor(0, 1);

  lcd.print(myRTC.hours);
  lcd.print(":");
  lcd.print(myRTC.minutes);
  lcd.print(":");
  lcd.print(myRTC.seconds);

  delay(300);

  for (int i = 0; i < 4; i++) {
  Serial.println("Pill ");
  Serial.print(i);
  Serial.print(" ");  
  Serial.print(pills[i].hour);
  Serial.print(":");
  Serial.println(pills[i].min);
  
    if (myRTC.hours == pills[i].hour && myRTC.minutes == pills[i].min && myRTC.seconds == 0) {
      myStepper.step(pills[i].stepperPos);
      delay(500);
      Serial.println(pills[i].stepperPos);

      myservo.write(180);
      delay(40);

      myservo.write(-150);
      delay(40);
      Serial.println("servo 0");
      myStepper.step(-pills[i].stepperPos);
    }
  }
  myservo.write(-180);
}
