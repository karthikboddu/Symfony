import { Component, OnInit, Input ,EventEmitter,Output} from '@angular/core';
import { Post, Response } from 'src/app/models/post';
import { PostService } from 'src/app/services/post.service';
import { first } from 'rxjs/operators';
import { ExploreService } from '../../explore.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-category-posts',
  templateUrl: './category-posts.component.html',
  styleUrls: ['./category-posts.component.scss']
})
export class CategoryPostsComponent implements OnInit {
  @Input() productDetails: Post;
  @Output() fileAdded1 = new EventEmitter<Post[]>();
  allPostDetails: Post[];
  public allPostObs: Observable<Post[]>;
  postResponse : Response;
  lastPostId = '';
  offset = '5';
  frontCoverImgPath;
  constructor(private postService: PostService,private exploreService:ExploreService) { }

  ngOnInit() {
    console.log(this.productDetails,"aaaaa");


    // this.postService.getAllPostsWithFileByActive(this.lastPostId,this.offset)
    // .pipe(first())
    // .subscribe(
    //   data => {
    //     this.postResponse = data;
    //     console.log("tdata", this.postResponse);
    //     this.allPostDetails = this.postResponse.data;
    //         for (let i = 0; i < this.allPostDetails.length; i++) {
    //           this.exploreService.setPost(i,this.allPostDetails[i]);
    //         }
    //     //this.allImg = data[0]['postfile'];
    //     console.log("catpostdata", this.allPostDetails);
    //     this.updatePost();
    //     //console.log("imgdata",data['postfile']);
    //   },
    //   error => {
    //     console.log("errors", error);
    //   });
  }

  onScroll(e) {
    console.log("scroll");
    // if (this.notscrolly && this.notEmptyPost) {
    //   this.spinner.show();
    //   this.notscrolly = false;
    //   this.loadNextPost();
    // }
  }


  getDefaultImagePath(){
    this.frontCoverImgPath = this.productDetails.uploadDetails[0].fileupload_imageUrl;
  }

  updateFilterPosts(){
    console.log("event0");
  }

  update(){
    console.log("update");
  }

  updatePost(){
    this.allPostObs =  this.exploreService.queryInFolder();
    console.log("ss",this.allPostObs);
  }

}
