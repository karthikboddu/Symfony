import { Component, OnInit, Input } from '@angular/core';
import { Post } from 'src/app/models/post';
import { ExploreService } from '../explore.service';

@Component({
  selector: 'app-post-display',
  templateUrl: './post-display.component.html',
  styleUrls: ['./post-display.component.scss']
})
export class PostDisplayComponent implements OnInit {
  @Input() productDetails: Post[];
  frontCoverImgPath;
  constructor(private exploreService:ExploreService) { }

  ngOnInit() {

    
  }

  ngAfterViewInit() {
    console.log("post-display11",this.productDetails)
    // for (let i = 0; i < this.productDetails.length; i++) {
    //    this.exploreService.setPost(i,this.productDetails[i]);
    // }
  }
  // getDefaultImagePath(){
  //   this.frontCoverImgPath = this.productDetails.uploadDetails[0].fileupload_imageUrl;
  // }

  productClick(){
    debugger
    //this.router.navigate([{ outlets: { modal: ['post-details', this.productDetails.userPost[0].p_id] } }]);  
  }
}
