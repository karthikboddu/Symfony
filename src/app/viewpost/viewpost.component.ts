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

  constructor(private postService: PostService,private http: HttpClient,private route: ActivatedRoute,
    private router: Router) { }
 allPost : any;
   page:any;
  pageUrl:any;
  ngOnInit() {
  	this.pageUrl = this.route.snapshot.queryParamMap.get('posturl');
  	if(this.pageUrl){
      this.getSinglePostS();
    }else{
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


    getSinglePostS(){
        this.pageUrl = this.route.snapshot.queryParamMap.get('posturl');
        this.router.navigate(['/viewpost'],this.pageUrl);
        console.log("page",this.pageUrl);
          this.postService.getSinglePostByUrl(this.pageUrl)
          .pipe(first())
          .subscribe(
            data => {
              this.allPost = data;
              console.log("posturldata",data);
            },
            error => {
                console.log(error);
            });
  }

}
