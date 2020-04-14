import { Component, OnInit, Output } from '@angular/core';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { Post } from '../models/post';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
import { EventEmitter } from 'events';

@Component({
  selector: 'app-movies',
  templateUrl: './movies.component.html',
  styleUrls: ['./movies.component.scss']
})
export class MoviesComponent implements OnInit {

  allPost : any;
  allImg : any;
  allTags : any;
  public imagePath;
  imgURL: any;
  public message: string;
  fileToUpload: File = null;
  sub:any;
  page:any;
  pageUrl:any;
  constructor(private postService: PostService,private http: HttpClient,  private route: ActivatedRoute,
    private router: Router) { }
    @Output() postsData = new EventEmitter();
  ngOnInit() {

    this.page = this.route.snapshot.queryParamMap.get('page');

    if(this.page){
      this.getPostTags();
    }
    else{
        this.postService.getById()
          .pipe(first())
          .subscribe(
              data => {  
                  this.allPost = data;
                  this.postsData.emit(this.allPost);
                  //this.allImg = data[0]['postfile'];
                  console.log("postsData",data);
                  //console.log("imgdata",data['postfile']);
              },
              error => {
                  console.log("errors",error);
              });
  
    }

    
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

    // this.sub = this.route
    //   .queryParams
    //   .subscribe(params => {
    //     // Defaults to 0 if no query param provided.
    //     this.page = +params['page'] || 0;
    //     console.log("page",this.page);
    //   });                  




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

  getPostTags(){
        this.page = this.route.snapshot.queryParamMap.get('page');
        this.router.navigate(['/home'],this.page);
        console.log("page",this.page);
          this.postService.postByTag(this.page)
          .pipe(first())
          .subscribe(
            data => {
              this.allPost = data;
              console.log("tagspost",data);
            },
            error => {
                console.log(error);
            });
  }


  getSinglePostS(){
        this.pageUrl = this.route.snapshot.queryParamMap.get('posturl');
        this.router.navigate(['/viewpost'],this.pageUrl);
        console.log("page",this.pageUrl);
          this.postService.getSinglePostByUrl(this.pageUrl)
          .pipe(first())
          .subscribe(
            data => {
              this.allPost = data;
              console.log("posturldata",data);
            },
            error => {
                console.log(error);
            });
  }
}
