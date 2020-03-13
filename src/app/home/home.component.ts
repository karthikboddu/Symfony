import { Component, OnInit, Output } from '@angular/core';
import { PostService } from '../services/post.service';
import { first, count } from 'rxjs/operators';
import { Post, Response } from '../models/post';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
import { Gallery, GalleryItem, ImageItem, ThumbnailsPosition, ImageSize } from '@ngx-gallery/core';
import { Lightbox } from '@ngx-gallery/lightbox';
import { EventEmitter } from 'events';
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  allPostDetails: Post[];
  postResponse : Response;
  allPostEmit: any;
  allPost: any;
  allImg: any;
  allTags: any;
  public imagePath;
  imgURL: any;
  public message: string;
  fileToUpload: File = null;
  sub: any;
  page: any;
  pageUrl: any;
  displayPosts: boolean = false;
  items: GalleryItem[];
  imageData :any;
  notscrolly = true;
  notEmptyPost = true;
  lastPostId = '';
  offset = '5';
  constructor(private postService: PostService, private http: HttpClient, private route: ActivatedRoute,
    private router: Router, public gallery: Gallery, public lightbox: Lightbox, private spinner: NgxSpinnerService) { }
  @Output() postsData = new EventEmitter();
  ngOnInit() {



debugger



this.items = dataImg.map(item => new ImageItem({ src: item.srcUrl, thumb: item.previewUrl
}));


/** Lightbox Example */

// Get a lightbox gallery ref
//const lightboxRef = this.gallery.ref('lightbox');
this.gallery.ref('lightbox').load(this.items);
// Add custom gallery config to the lightbox (optional)
// lightboxRef.setConfig({
//  imageSize: ImageSize.Cover,
//  thumbPosition: ThumbnailsPosition.Top
// });

// Load items into the lightbox gallery ref
//lightboxRef.load(this.items);




    this.page = this.route.snapshot.queryParamMap.get('page');

    if (this.page) {
      this.getPostTags();
    }
    // else{
    //     this.postService.getById()
    //       .pipe(first())
    //       .subscribe(
    //           data => {  
    //               this.allPostDetails = data;
    //               this.allPostEmit = data;
    //               this.postsData.emit(this.allPostEmit);
    //               //this.allImg = data[0]['postfile'];
    //               console.log("data",data);
    //               //console.log("imgdata",data['postfile']);
    //           },
    //           error => {
    //               console.log("errors",error);
    //           });

    // }
    else {
      this.postService.getAllPostsWithFileByActive(this.lastPostId,this.offset)
        .pipe(first())
        .subscribe(
          data => {
            this.postResponse = data;
            console.log("tdata", this.postResponse);
            this.allPostDetails = this.postResponse.data;
            this.allPostEmit = data;
            this.postsData.emit(this.allPostEmit);
            //this.allImg = data[0]['postfile'];
            console.log("postdata", this.allPostDetails);
            //console.log("imgdata",data['postfile']);
          },
          error => {
            console.log("errors", error);
          });
    }
    // if(count(this.allPost)){
    //   this.displayPosts = true;
    // }

    this.postService.getTags()
      .pipe(first())
      .subscribe(
        data => {
          this.allTags = data;
          console.log("tags", data);
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

  preview(files: FileList) {
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

    this.postService.upload(this.fileToUpload, this.imagePath)
      .pipe(first())
      .subscribe(
        data => {

          console.log("qllW", data);
        },
        error => {
          console.log(error);
        }
      )

  }

  getPostTags() {
    this.page = this.route.snapshot.queryParamMap.get('page');
    this.router.navigate(['/home'], this.page);
    console.log("page", this.page);
    this.postService.postByTag(this.page)
      .pipe(first())
      .subscribe(
        data => {
          this.allPost = data;
          console.log("tagspost", data);
        },
        error => {
          console.log(error);
        });
  }


  getSinglePostS() {
    this.pageUrl = this.route.snapshot.queryParamMap.get('posturl');
    this.router.navigate(['/viewpost'], this.pageUrl);
    console.log("page", this.pageUrl);
    this.postService.getSinglePostByUrl(this.pageUrl)
      .pipe(first())
      .subscribe(
        data => {
          this.allPost = data;
          console.log("posturldata", data);
        },
        error => {
          console.log(error);
        });
  }



  onScroll(e) {
    console.log("scroll");
    if (this.notscrolly && this.notEmptyPost) {
      this.spinner.show();
      this.notscrolly = false;
      this.loadNextPost();
    }
  }


  loadNextPost() {
    debugger
    const lastPost = this.allPostDetails.length-1;
    // get id of last post
    //  backend of this app use this id to get next 6 post
    //const lastPostId = lastPost.userPost[0]['p_id'];
    console.log(lastPost,"userpost");
    const limit = '5';
    // sent this id as key value pare using formdata()
    // const dataToSend = new FormData();
    // dataToSend.append('id', lastPostId);
    // dataToSend.append('offset', offset);
    // call http request


    this.postService.getAllPostsWithFileByActive(lastPost,limit)
    .pipe(first())
    .subscribe(
      data => {
        debugger
        console.log("newdata",data);
        const newPost = data.data;
  
        this.spinner.hide();
  
        if (newPost.length === 0 ) {
          this.notEmptyPost =  false;
          console.log("end!!!!!!!");
        }
        if(newPost.length>0){
           // add newly fetched posts to the existing post
          this.allPostDetails = this.allPostDetails.concat(newPost);
  
          this.notscrolly = true;
        }
       
        
      },
      error => {
        console.log("errors", error);
      });
  }

}


const dataImg = [
  {
    srcUrl: 'https://preview.ibb.co/mwsA6R/img7.jpg',
    previewUrl: 'https://preview.ibb.co/mwsA6R/img7.jpg'
  },
  {
    srcUrl: 'https://preview.ibb.co/kZGsLm/img8.jpg',
    previewUrl: 'https://preview.ibb.co/kZGsLm/img8.jpg'
  }
];