import { Component, OnInit, Input } from '@angular/core';
import { Post } from 'src/app/models/post';

@Component({
  selector: 'app-core-details',
  templateUrl: './core-details.component.html',
  styleUrls: ['./core-details.component.scss']
})
export class CoreDetailsComponent implements OnInit {
  @Input() productDetails: Post[];
  frontCoverImgPath :any
  constructor() { }

  ngOnInit() {

    this.frontCoverImgPath = this.productDetails[0].uploadDetails[0].fileupload_imageUrl;
    console.log(this.frontCoverImgPath,"frontCoverImgPath");
  }

}
