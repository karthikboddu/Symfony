import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from './services/authentication.service';
import { first } from 'rxjs/operators';
import { Router, ActivatedRoute } from '@angular/router';
import { PostService } from './services/post.service';
import { FormControl } from '@angular/forms';
import { ThemeService } from './services/theme.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'demoproject';
  darkTheme =  new FormControl(false);
  constructor(private authService : AuthenticationService,private route: ActivatedRoute,private postService: PostService
   , private router: Router,private themeService:ThemeService
   ) {


   }
isAuthenticated : boolean;
isTokenValid :any;
allPost : any;
admin :boolean;
loggedin : boolean;
ngOnInit() {
    
       console.log("isauth",this.isAuthenticated);
      //  if(this.isAuthenticated){
      //   this.router.navigate(['/home']);
      //  }else{
      //   this.router.navigate(['/login']);
      //  }

      this.postService.getPostsByHomeScreen()
          .pipe(first())
          .subscribe(
              data => {  
                 this.allPost = data
                  //this.allImg = data[0]['postfile'];
                  console.log("data",this.allPost);
                  //console.log("imgdata",data['postfile']);
              },
              error => {
                  console.log("errors",error);
              });
  
       
}



}
