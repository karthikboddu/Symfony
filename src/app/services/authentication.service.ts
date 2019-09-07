import { Injectable } from '@angular/core';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService) { }

  login(username: string, password: string) {
      return this.http.post<any>(this.serviceUrl.host+this.serviceUrl.login, { username: username, password: password });

  }

  logout() {
      // remove user from local storage to log user out
      localStorage.removeItem('currentUser');
  }

  public getToken(): string {
    return localStorage.getItem('currentUser');
  }
}
