import { Component, OnInit,Output } from '@angular/core';
import { PostService } from '../services/post.service';
import { first, count } from 'rxjs/operators';
import { Post } from '../models/post';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
import { Gallery, GalleryItem, ImageItem, ThumbnailsPosition, ImageSize } from '@ngx-gallery/core';
import { Lightbox } from '@ngx-gallery/lightbox';
import { EventEmitter } from 'events';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  allPostDetails : Post[];
  allPostEmit  : any;
  allPost :any;
  allImg : any;
  allTags : any;
  public imagePath;
  imgURL: any;
  public message: string;
  fileToUpload: File = null;
  sub:any;
  page:any;
  pageUrl:any;
  displayPosts:boolean = false;
  items: GalleryItem[];
  imageData = data;
  constructor(private postService: PostService,private http: HttpClient,  private route: ActivatedRoute,
    private router: Router,public gallery: Gallery, public lightbox: Lightbox) { }
    @Output() postsData = new EventEmitter();
  ngOnInit() {


 /** Basic Gallery Example */
debugger
    // Creat gallery items
    this.items = this.imageData.map(item => new ImageItem({ src: item.srcUrl, thumb: item.previewUrl }));
    

    /** Lightbox Example */

    // Get a lightbox gallery ref
    const lightboxRef = this.gallery.ref('lightbox');

    // Add custom gallery config to the lightbox (optional)
    lightboxRef.setConfig({
      imageSize: ImageSize.Cover,
      thumbPosition: ThumbnailsPosition.Top
    });

    // Load items into the lightbox gallery ref
    lightboxRef.load(this.items);






    this.page = this.route.snapshot.queryParamMap.get('page');

    if(this.page){
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
    else{
      this.postService.getAllPostsWithFileByActive()
      .pipe(first())
      .subscribe(
          data => {  
              this.allPostDetails = data;
              this.allPostEmit = data;
              this.postsData.emit(this.allPostEmit);
              //this.allImg = data[0]['postfile'];
              console.log("data",data);
              //console.log("imgdata",data['postfile']);
          },
          error => {
              console.log("errors",error);
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


const data = [
  {
    srcUrl: 'https://my-blog-19.s3.ap-south-1.amazonaws.com/karthikboddu/jpeg/download.jpeg',
    previewUrl: 'https://my-blog-19.s3.ap-south-1.amazonaws.com/karthikboddu/jpeg/download.jpeg'
  },
  {
    srcUrl: 'https://my-blog-19.s3.ap-south-1.amazonaws.com/karthikboddu/jpg/259316.jpg',
    previewUrl: 'https://my-blog-19.s3.ap-south-1.amazonaws.com/karthikboddu/jpg/259316.jpg'
  },
  {
    srcUrl: 'https://preview.ibb.co/mwsA6R/img7.jpg',
    previewUrl: 'https://preview.ibb.co/mwsA6R/img7.jpg'
  },
  {
    srcUrl: 'https://preview.ibb.co/kZGsLm/img8.jpg',
    previewUrl: 'https://preview.ibb.co/kZGsLm/img8.jpg'
  }
];