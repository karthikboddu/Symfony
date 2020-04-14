import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {ServiceUrlService} from '../../serviceUrl/service-url.service';
import { AuthenticationService } from '../../services/authentication.service';
import { Post, Response } from '../../models/post';
import { v4 } from 'uuid';
import { BehaviorSubject } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class ExploreService {
  private postMap = new Map<number, Post>();

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService,private authenticationService: AuthenticationService) {}


  setPost(id,post:Post){
    debugger
    console.log("singlepost",post);
    if((this.postMap.size)>0){
      this.postMap.forEach(element => {
        if (element[0].p_id === post[0].p_id) {
          
        }else{
           this.postMap.set(v4(),post)
        }
      });
    }else{
      this.postMap.set(v4(),post)
    }

   
      return post;
  }

  getPost(){
    console.log(this.postMap,"map");
  }

  private querySubject: BehaviorSubject<Post[]>;
  queryInFolder(postId='') {
    debugger
    const result: Post[] = [];
    this.postMap.forEach(element => {
      if (element[0].p_id === postId) {
        result.push(this.clone(element));
      }
      if(postId==''){
        result.push(this.clone(element));
      }
    });

    if (!this.querySubject) {
      this.querySubject = new BehaviorSubject(result);
    } else {
      this.querySubject.next(result);
    }
    return this.querySubject.asObservable();
  }

  clone(element: Post) {
    return JSON.parse(JSON.stringify(element));
  }

  getMediaDataByType(id){
    this.postMap.forEach(element => {
      console.log("DFDD",element.uploadDetails[0].futn_id);
      if (element.uploadDetails[0].futn_id == id) {
          console.log("eleem",element);
          this.queryInFolder(element[0].p_id);
      }
    });
  }

}