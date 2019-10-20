import { Component, OnInit } from '@angular/core';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-slider-image',
  templateUrl: './slider-image.component.html',
  styleUrls: ['./slider-image.component.scss']
})
export class SliderImageComponent implements OnInit {

  constructor(private postService:PostService) { }
  allPost:any;
  ngOnInit() {
    this.postService.getPostsByHomeScreen()
    .pipe(first())
    .subscribe(
        data => {  
           this.allPost = data
            //this.allImg = data[0]['postfile'];
            console.log("data",this.allPost);
            //console.log("imgdata",data['postfile']);
        },
        error => {
            console.log("errors",error);
        });
  }

}
