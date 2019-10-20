import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthenticationService } from '../services/authentication.service';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-headers',
  templateUrl: './headers.component.html',
  styleUrls: ['./headers.component.scss']
})
export class HeadersComponent implements OnInit {

  constructor(private authService : AuthenticationService,private route: ActivatedRoute,private postService: PostService
    , private router: Router,
    ) {}
 isAuthenticated : boolean;
 isTokenValid :any;
 allPost : any;
 admin :boolean;
 loggedin : boolean;

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

}
