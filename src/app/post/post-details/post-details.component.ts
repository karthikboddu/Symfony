import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { PostService } from 'src/app/services/post.service';
import { first } from 'rxjs/operators';
import { Post, Response } from 'src/app/models/post';

@Component({
  selector: 'app-post-details',
  templateUrl: './post-details.component.html',
  styleUrls: ['./post-details.component.scss']
})
export class PostDetailsComponent implements OnInit {

  constructor(private activatedRoute:ActivatedRoute,private postService:PostService) { }
  allPostDetails: Post[];
  postResponse : Response;
  tocExpanded;
  ngOnInit() {
    let sub = this.activatedRoute.params.subscribe(routeParams => {
      let postId = routeParams.id;
      console.log(postId,"postid");
      this.allPostDetails = null;
      if (!postId) {
        throw Error("Mandatory query param 'product ID' not provided to ProductDetailsComponent");
      }
      // this.setAuthStatus();
      this.fetchProductDetails(postId);
//      this.fetchRelatedProducts(productId);
    });

  }

  fetchProductDetails(postId){
    this.postService.getSinglePostWithFileByActive(postId)
    .pipe(first())
    .subscribe(
      data => {
        this.postResponse = data;
        console.log("tdata", this.postResponse);
        this.allPostDetails = this.postResponse.data;
        //this.allImg = data[0]['postfile'];
        console.log("postdata", this.allPostDetails);
        //console.log("imgdata",data['postfile']);
      },
      error => {
        console.log("errors", error);
      });
  }

}
