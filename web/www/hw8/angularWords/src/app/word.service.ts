import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class WordService {
  path:string;

  constructor(
    private http:HttpClient
  ) { 
    // this.path = "http://localhost:8080/hw8/wordle_api.php";
    this.path = "https://cs4640.cs.virginia.edu/vpv4ds/hw8/wordle_api.php";
  }

  sendRequest():Observable<any> {
    return this.http.get(this.path);
  }

}
