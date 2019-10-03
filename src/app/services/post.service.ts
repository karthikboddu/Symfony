import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
import { Post } from '../models/post';
import { AuthenticationService } from './authentication.service';
import { post } from 'selenium-webdriver/http';

@Injectable({
  providedIn: 'root'
})
export class PostService {

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService,private authenticationService: AuthenticationService) { }

    getAll() {
        return this.http.get<Post[]>(`/posts`);
    }

    getById() {
      debugger
        let headers = new HttpHeaders({ 'Content-Type': 'application/json' });

        headers = headers.append('Authorization', 'Bearer ' + this.authenticationService.getToken());
      
        return this.http.get(this.serviceUrl.host+this.serviceUrl.postid,{headers: headers});
    }

    post(posts,imagePath,fileToUpload,divTags) {
        debugger
       
        let uploads = new FormData();
        uploads.append("file",fileToUpload);
        uploads.append("imgname",imagePath);
        uploads.append("name",posts.name);
        uploads.append("description",posts.description);
        let headers = new HttpHeaders();
  
        headers = headers.append('Authorization', 'Bearer ' + this.authenticationService.getToken());
        
        return this.http.post(this.serviceUrl.host+this.serviceUrl.post,uploads,{headers:headers});
    }

    update(post: Post) {
        return this.http.put(`/users/` + post.id, post);
    }

    delete(id: number) {
        return this.http.delete(`/posts/` + id);
    }

    getTags(){
      return this.http.get(this.serviceUrl.host+this.serviceUrl.tags);
    }

    upload(file,name){
      debugger
      let uploads = new FormData();
      uploads.append("file",file);
      uploads.append("name",name);
      let headers = new HttpHeaders();

      headers = headers.append('Authorization', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.post(this.serviceUrl.host+this.serviceUrl.upload,uploads,{headers:headers});
    }

    postByTag(tag){
      debugger
      let headers = new HttpHeaders();
       
      headers = headers.append('Authorization', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.get(this.serviceUrl.host+this.serviceUrl.postByTag+"/"+tag,{headers:headers});
    }

    getSinglePostByUrl(postUrl){
      let headers = new HttpHeaders();

      headers = headers.append('Authorization', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.post(this.serviceUrl.host+this.serviceUrl.singlePost+"/"+postUrl,{headers:headers});
    }

}
