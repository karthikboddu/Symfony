import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthenticationService } from '../services/authentication.service';
import { first } from 'rxjs/operators';
import { AlertService } from '../services/alert.service';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;

  constructor(
      private formBuilder: FormBuilder,
      private route: ActivatedRoute,
      private router: Router,
      private authenticationService: AuthenticationService,
      private alertService: AlertService) {}

  ngOnInit() {
      this.loginForm = this.formBuilder.group({
          username: ['', Validators.required],
          password: ['', Validators.required]
      });
    //   if(this.authenticationService.isLoggedIn){
    //       this.closeModal();
    //   }
      // reset login status
      //this.authenticationService.logout();

      // get return url from route parameters or default to '/'
      //this.returnUrl = 'home';
  }

  // convenience getter for easy access to form fields
  get f() { return this.loginForm.controls; }

  onSubmit() {
      this.submitted = true;

      // stop here if form is invalid
      if (this.loginForm.invalid) {
          return;
      }

      this.loading = true;
      this.authenticationService.login(this.f.username.value, this.f.password.value)
          .pipe(first())
          .subscribe(
              data => {
                  debugger 
                  if(data.status){
                    this.router.navigate([this.returnUrl]);
                    this.authenticationService.setLoggedIn(true);
                    debugger
                    if(data.isAdmin){
                        console.log("admin",data.isAdmin);
                        this.authenticationService.setAdmin(true);
                    }
                    console.log("admin",data.isAdmin);
                    localStorage.setItem('currentUser', JSON.stringify(data));
                  }else{
                    this.alertService.error(data.message);
                    this.loading = false;
                  }
                  
              },
              error => {
                  console.log("errors",error);
                  this.alertService.error(error.statusText);
                  this.loading = false;
              });
  }

  closeModal() {
    //this.enableBodyScroll();
    this.router.navigate([{ outlets: { modal: null } }]);
  }
}
