import { Component, OnInit, Input } from '@angular/core';
import { Post ,Response} from 'src/app/models/post';
import { ExploreService } from './explore.service';
import { Observable } from 'rxjs';
import { PostService } from 'src/app/services/post.service';
import { first } from 'rxjs/operators';
import { Track } from 'ngx-audio-player';   

@Component({
  selector: 'app-explore',
  templateUrl: './explore.component.html',
  styleUrls: ['./explore.component.scss']
})
export class ExploreComponent implements OnInit {
  @Input() productDetails: Post;
  constructor(private postService: PostService,private exploreService:ExploreService) { }
  allPostDetails: Post[];
  public allPostObs: Observable<Post[]>;
  postResponse : Response;
  lastPostId = '';
  offset = '50';
  frontCoverImgPath;
  showFilter;




  ngOnInit() {
    this.postService.getAllPostsWithFileByActive(this.lastPostId,this.offset)
    .pipe(first())
    .subscribe(
      data => {
        this.postResponse = data;
        console.log("tdata", this.postResponse);
        this.allPostDetails = this.postResponse.data;
            for (let i = 0; i < this.allPostDetails.length; i++) {
              this.exploreService.setPost(i,this.allPostDetails[i]);
            }
        //this.allImg = data[0]['postfile'];
        console.log("catpostdata", this.allPostDetails);
        this.updatePost();
        //console.log("imgdata",data['postfile']);
      },
      error => {
        console.log("errors", error);
      });
  }

  update(event){
    this.productDetails = event;
    console.log("expolre", this.productDetails)
    //  for (let i = 0; i < this.productDetails.length; i++) {
       this.exploreService.setPost(3,this.productDetails);
  //  }
    this.exploreService.getPost();
    this.updatePost();
  }

  updatePost(){
    this.allPostObs =  this.exploreService.queryInFolder();
    console.log("ss",this.allPostObs);
  }

  enableFilter(){

  }

  ngOnDestroy() {
    this.exploreService.clearPost();
   }
}
