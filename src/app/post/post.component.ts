import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { AlertService } from '../services/alert.service';

@Component({
  selector: 'app-post',
  templateUrl: './post.component.html',
  styleUrls: ['./post.component.scss']
})
export class PostComponent implements OnInit {

  loginForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;

  constructor(
      private formBuilder: FormBuilder,
      private route: ActivatedRoute,
      private router: Router,
      private postService: PostService,
      private alertService: AlertService) {}

  ngOnInit() {
      this.loginForm = this.formBuilder.group({
          name: ['', Validators.required],
          description: ['', Validators.required]
      });

      // reset login status
      

      // get return url from route parameters or default to '/'
      this.returnUrl = 'home';
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
      this.postService.post(this.loginForm.value)
          .pipe(first())
          .subscribe(
              data => {  
                  console.log("data",data);
                  this.router.navigate([this.returnUrl]);
                  this.loading = true;
              },
              error => {
                  console.log("errors",error);
                  this.alertService.error(error.statusText);
                  this.loading = false;
              });
  }

  

}
