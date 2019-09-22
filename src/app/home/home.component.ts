import { Component, OnInit } from '@angular/core';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { Post } from '../models/post';
import { HttpClient } from '@angular/common/http';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  allPost : any;
  allTags : any;
  public imagePath;
  imgURL: any;
  public message: string;
  fileToUpload: File = null;
  
  constructor(private postService: PostService,private http: HttpClient) { }

  ngOnInit() {
  	this.postService.getById()
  	      .pipe(first())
          .subscribe(
              data => {  
                  this.allPost = data;
                  
                  console.log("data",data);
              },
              error => {
                  console.log("errors",error);
              });

    
    this.postService.getTags()
          .pipe(first())
          .subscribe(
            data => {
              this.allTags = data;
              console.log("tags",data);
            },
            error => {
                console.log(error);
            }
          )          
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

    this.postService.upload(this.fileToUpload,this.imagePath)
    .pipe(first())
    .subscribe(
      data => {
        
        console.log("qllW",data);
      },
      error => {
          console.log(error);
      }
    )      

  }

}
