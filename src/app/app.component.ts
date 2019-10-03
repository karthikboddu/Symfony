import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from './services/authentication.service';
import { first } from 'rxjs/operators';
import { Router, ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'demoproject';

  constructor(private authService : AuthenticationService,private route: ActivatedRoute,
    private router: Router,
   ) {}
isAuthenticated : boolean;
ngOnInit() {
   this.authService.getAuth() .pipe(first())
   .subscribe(
       data => {  
            this.isAuthenticated = true;         
           console.log("auth",data);
       },
       error => {
          this.isAuthenticated = false;
           console.log("errors",error);
       });
       console.log("isauth",this.isAuthenticated);
      //  if(this.isAuthenticated){
      //   this.router.navigate(['/home']);
      //  }else{
      //   this.router.navigate(['/login']);
      //  }
       
}



}
