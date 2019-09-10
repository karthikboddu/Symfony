import { Component, OnInit } from '@angular/core';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { Post } from '../models/post';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

	allPost : any;
  constructor(private postService: PostService) { }

  ngOnInit() {
  	this.postService.getById()
  	      .pipe(first())
          .subscribe(
              data => {  
                  this.allPost = data;
                  
                  console.log("data",data);
              },
              error => {
                  console.log("errors",error);
              });
  }

}
