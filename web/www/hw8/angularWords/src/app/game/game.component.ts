import { Component } from '@angular/core';
import { Observable, throwError } from 'rxjs';

import { WordService } from 'app/word.service';
import { Guess } from 'app/guess';

@Component({
  selector: 'app-game',
  templateUrl: './game.component.html',
  styleUrl: './game.component.css'
})
export class GameComponent {
    guessModel:Guess;
    guessCorrect:boolean;
    numGuesses:number;

    public word:string = "default";

    public guessesLog:Array<string>;

    constructor(private wordService:WordService) {
      this.wordService.sendRequest().subscribe(
        (respData) => {
          this.word = respData;
        }
      );
      this.guessesLog = [];
      this.guessModel = new Guess("");
      this.guessCorrect = false;
      this.numGuesses = 0;
    }

    submitGuess() {
        console.log("submit Guess");
        let guessText = this.guessModel.guess;
        if(guessText == this.word) { //correct GUESS
            this.guessCorrect = true;
        }
        else {
            let message = "";
            let numCorrectCharacters = 0;
            for(let i = 0; i < guessText.length; i++) {
                if(this.word.indexOf(guessText[i]) != -1) {
                    numCorrectCharacters++;
                }
            }
            let numCorrectPosition = 0;
            for(let i = 0; i < guessText.length && i < this.word.length; i++) {
                if(guessText[i] == this.word[i]) {
                    numCorrectPosition++;
                }
            }
            if(guessText.length > this.word.length) {
                message += "Guess was " + (guessText.length - this.word.length) + " too many letters!";
            }
            else if(guessText.length < this.word.length) {
                message += "Guess was " + (this.word.length - guessText.length) + " too little letters!";
            }
            else {
                message += "Guess was Correct length!";
            }
            message += " " + numCorrectCharacters + " characters in the guess we in the target word and " + numCorrectPosition + " characters were in the correct position!";
            this.guessesLog.push(message);
        }

        this.numGuesses += 1;
    }

    restart() {
        this.wordService.sendRequest().subscribe(
        (respData) => {
          this.word = respData;
        }
      );
      this.guessesLog = [];
      this.guessModel = new Guess("");
      this.guessCorrect = false;
      this.numGuesses = 0;
    }
}
