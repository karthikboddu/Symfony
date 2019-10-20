import { Injectable } from '@angular/core';
import { ServiceUrlService } from '../serviceUrl/service-url.service';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { Router } from '@angular/router';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  tokenExists:any;
  constructor(private http: HttpClient, private serviceUrl: ServiceUrlService,private router: Router) { 
    //this.handleAuth();
    debugger
    this.tokenExists = this.getToken();
    if(this.tokenExists){
      this.setLoggedIn(true);
      this.currentUserSubject = new BehaviorSubject<boolean>(JSON.parse(localStorage.getItem('currentUser')));
      this.currentUser = this.currentUserSubject.asObservable();
      this.isAdmin = this.currentUserValue.isAdmin;
      if(this.isAdmin){
        this.setAdmin(true);
      }
      
    }else{
      this.router.navigate(['/login']);
    }
    //console.log("currentuser",this.currentUserValue);
  }

  isTokenValid :boolean;
  userInfo:any;
  isAdmin : boolean
  private currentUserSubject: BehaviorSubject<boolean>;
  public currentUser: Observable<boolean>;
  isAdmin$ = new BehaviorSubject<boolean>(this.isAdmin);
  isLoggedIn: boolean;
  loggedIn$ = new BehaviorSubject<boolean>(this.isLoggedIn);
  loggingIn: boolean;

  login(username: string, password: string) {
    return this.http.post<any>(this.serviceUrl.host + this.serviceUrl.login, { username: username, password: password });

  }

  public get currentUserValue(): any {
    debugger
    if(this.tokenExists){
      return this.currentUserSubject.value;
    }
    
  }

  setLoggedIn(value: boolean) {
    // Update login status subject
    this.loggedIn$.next(value);
    this.isLoggedIn = value;
  }

  setAdmin(value: boolean) {
    // Update login status subject
    this.isAdmin$.next(value);
    this.isAdmin = value;
  }

  getAdmin(){
    if(this.isAdmin$.value){
      return this.isAdmin$.value;
    }
  }
  logout() {
    // remove user from local storage to log user out
    this.router.navigate(['/login']);
    localStorage.removeItem('currentUser');
  }

  public getToken(): string {
    debugger
    this.userInfo =  JSON.parse(localStorage.getItem('currentUser'));
    if(this.userInfo){
      return this.userInfo.token;
    }
    
  }

  getAuth() {
    debugger
    let headers = new HttpHeaders();

    headers = headers.append('Authorization', 'Bearer ' + this.getToken());

    return this.http.get<any>(this.serviceUrl.host + this.serviceUrl.getAuth, { headers: headers });
  }

  handleAuth(){
 
    if(this.isLoggedIn){
      this._getProfile();
    }else{
      this.isAdmin$.subscribe(isad=>{
        console.log("isad",isad);
        this.isLoggedIn = isad;
      });
      this.loggedIn$.subscribe(islog=>{
        console.log("islog",islog);
        this.isLoggedIn = islog;
      });
      //this._clearRedirect();
      //  this.router.navigate(['/']);
      console.error(`Error authenticating`);

    }
  }

  private _getProfile(){
    this._redirect();
  }

  private _redirect() {
    const redirect = decodeURI(localStorage.getItem('authRedirect'));
    const navArr = [redirect || '/'];

    this.router.navigate(navArr);
    // Redirection completed; clear redirect from storage
    this._clearRedirect();
  }

  tokenValid(){
    debugger
    let headers = new HttpHeaders();

    headers = headers.append('Authorization', 'Bearer ' + this.getToken());

    this.http.get(this.serviceUrl.host + this.serviceUrl.isTokenValid, { headers: headers })
    .subscribe(
      data => { 
        this.isTokenValid = true;
      },
      error => {
          console.log("tokenvalid",error);
          this.logout;
          this.isTokenValid = false;
      });
  }


  private _clearRedirect() {
    // Remove redirect from localStorage
    localStorage.removeItem('authRedirect');
  }
}
