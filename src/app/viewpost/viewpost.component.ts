import { Component, OnInit } from '@angular/core';
import { PostService } from '../services/post.service';
import { first } from 'rxjs/operators';
import { Post } from '../models/post';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
@Component({
  selector: 'app-viewpost',
  templateUrl: './viewpost.component.html',
  styleUrls: ['./viewpost.component.scss']
})
export class ViewpostComponent implements OnInit {

  constructor(private postService: PostService,private http: HttpClient) { }
 allPost : any;
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
