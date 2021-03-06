import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthenticationService } from '../services/authentication.service';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { ThemeService } from '../services/theme.service';
import { FormControl } from '@angular/forms';
import { faSearch, faBell, faUser } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-headers',
  templateUrl: './headers.component.html',
  styleUrls: ['./headers.component.scss']
})
export class HeadersComponent implements OnInit {
  darkTheme =  new FormControl(false);
  constructor(public authService : AuthenticationService,private route: ActivatedRoute,private postService: PostService
    , private router: Router,private themeService:ThemeService
    ) {
      console.log("theme",this.darkTheme);
      this.darkTheme.valueChanges.subscribe(value => {
        if (value) {
          this.themeService.toggleDark();
        } else {
          this.themeService.toggleLight();
        }
      });
    }
 isAuthenticated : boolean;
 isTokenValid :any;
 allPost : any;
 admin :boolean;
 loggedin : boolean;
 faSearch = faSearch;
  faBell = faBell;
  faUser = faUser;
  ngOnInit() {
    console.log("adminshow",this.authService.isLoggedIn);
    console.log("loginshow", this.authService.isAdmin);
   this.authService.getAuth().pipe(first())
   .subscribe(
       data => {  
            this.isAuthenticated = true;
            if(!data.code){
                this.authService.logout();
            }
           console.log("auth",data.code);
       },
       error => {
           
          this.isAuthenticated = false;
           console.log("errors",error);
       });
  }

  onLogIn() {
    debugger
    this.router.navigate([{ outlets: { modal: ['auth/login'] } }]);
  }

}
