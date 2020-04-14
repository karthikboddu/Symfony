import { Component, OnInit, Input, Output ,EventEmitter} from '@angular/core';
import { Post, Response } from 'src/app/models/post';
import { PostService } from 'src/app/services/post.service';
import { first } from 'rxjs/operators';


@Component({
  selector: 'app-category-display',
  templateUrl: './category-display.component.html',
  styleUrls: ['./category-display.component.scss']
})
export class CategoryDisplayComponent implements OnInit {
  @Input() productDetails: Post;
  //@Output() fileAdded1 = new EventEmitter<Post[]>();

  allPostDetails: Post[];
  postResponse : Response;
  lastPostId = '';
  offset = '5';
  constructor(private postService: PostService) { }

  ngOnInit() {
    console.log("productDetails",this.productDetails);
   // this.fileAdded1.emit();
  }

  onScroll() {
    console.log("scroll");
    // if (this.notscrolly && this.notEmptyPost) {
    //   this.spinner.show();
    //   this.notscrolly = false;
    //   this.loadNextPost();
    // }
  }


}
