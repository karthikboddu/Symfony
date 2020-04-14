import { Component, OnInit, Input, Output ,EventEmitter} from '@angular/core';
import { PostService } from 'src/app/services/post.service';
import { first } from 'rxjs/operators';
import { Post, Response } from 'src/app/models/post';
import { FileElement } from 'src/app/models/file-explorer';
import { ExploreService } from '../explore/explore.service';

@Component({
  selector: 'app-post-filter',
  templateUrl: './post-filter.component.html',
  styleUrls: ['./post-filter.component.scss']
})
export class PostFilterComponent implements OnInit {

  constructor(private postService:PostService,private exploreService:ExploreService) { }
  //@Input() productDetails: Post;
  
  allPostDetails: Post[];
  postResponse : Response;
  ngOnInit() {
  }
  @Output() loadFilter = new EventEmitter<Post[]>();
  @Output() onClearAll = new EventEmitter<Post[]>();
  filterType = ['All','Audio','Video'];
  onLoadFilter(){
    debugger
    this.onClearAll.emit();
    this.exploreService.getMediaDataByType('1');
    //this.loadFilter.emit();
  }

  clearAllFilters(){
    debugger
    this.onClearAll.emit();
  }
}
