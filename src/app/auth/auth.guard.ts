import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthenticationService } from '../services/authentication.service';

@Injectable({
  providedIn: 'root'
})


export class AuthGuard implements CanActivate {
  constructor(private auth :AuthenticationService,private router: Router){

  }
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {

      // if (!this.auth.isLoggedIn) {
      //   localStorage.setItem('authRedirect', state.url);
      // }
      // if (!this.auth.isTokenValid && !this.auth.isLoggedIn) {
      //   //this.auth.login();
      //   return false;
      // }
      // if (this.auth.isTokenValid && this.auth.isLoggedIn) {
      //   return true;
      // }

      if(this.auth.currentUserValue){
        console.log("aaaaaaa",this.auth.currentUserValue);
        return true;
      }
      
      return false; 
  }
  
}
