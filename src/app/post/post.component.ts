import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { AlertService } from '../services/alert.service';
import {Tags} from '../models/tags';
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
      this.getAllTags();
      // reset login status
      // get return url from route parameters or default to '/'
      this.returnUrl = 'home';
      this.imgURL = 'http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg';
  }
  divs: number[] = [];
  divtags : string[]=[];
  public imagePath;
  imgURL: any;
  public message: string;
  fileToUpload: File = null;
  allTags :any;
  createDiv(): void {
      debugger
    this.divs.push(this.divs.length);
  }
  removeDiv(){
      debugger
    this.divs.pop();
  }
  createTag(selected): void {
    debugger
  this.divtags.push(selected);
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

  preview(files:FileList) {
    debugger
    if (files.length === 0)
      return;
      this.fileToUpload = files.item(0);
    var mimeType = files[0].type;
    if (mimeType.match(/image\/*/) == null) {
      this.message = "Only images are supported.";
      return;
    }
 
    var reader = new FileReader();
    this.imagePath = files[0]['name'];
    reader.readAsDataURL(files[0]); 
    reader.onload = (_event) => { 
      this.imgURL = reader.result; 
      console.log(reader);
    }
  }

  getAllTags(){
    this.postService.getTags()
    .pipe(first())
    .subscribe(
      data => {
        this.allTags = data;
        console.log("tags",data);
      },
      error => {
          console.log(error);
      });
  }

  

}
