import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
import { AuthenticationService } from './authentication.service';
import { Post, Response } from '../models/post';
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

        headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
      
        return this.http.get<Post[]>(this.serviceUrl.host+this.serviceUrl.postid,{headers: headers});
    }

    post(posts,fileToUpload,divTags) {
        debugger
       
        let uploads = new FormData();
        uploads.append("file",fileToUpload);
     
        uploads.append("name",posts.name);
        uploads.append("description",posts.description);
        uploads.append("tags",divTags);
        let headers = new HttpHeaders();
  
        headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
        
        return this.http.post(this.serviceUrl.host+this.serviceUrl.post,uploads,{headers:headers});
    }

    // update(post: Post) {
    //     return this.http.put(`/users/` + post.id, post);
    // }

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

      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.post(this.serviceUrl.host+this.serviceUrl.upload,uploads,{headers:headers});
    }

    postByTag(tag){
      debugger
      let headers = new HttpHeaders();
       
      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.get(this.serviceUrl.host+this.serviceUrl.postByTag+"/"+tag,{headers:headers});
    }

    getSinglePostByUrl(postUrl){
      let headers = new HttpHeaders();

      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.post(this.serviceUrl.host+this.serviceUrl.singlePost+"/"+postUrl,{headers:headers});
    }

    getPostsByHomeScreen(){
      
      return this.http.get(this.serviceUrl.host+this.serviceUrl.postsByHomeScreen);
    }

    getTotalPostsByActive(){
  
      return this.http.get(this.serviceUrl.host+this.serviceUrl.adminTotalPostsActive);
    }
    getAllPostsWithFileByActive(offset,limit){
      let scrollData = new FormData();
      scrollData.append("limit",limit);
      scrollData.append("offset",offset);
      return this.http.post<Response>(this.serviceUrl.host+this.serviceUrl.getAllPostWithFileDetails,scrollData);
    }

    getSinglePostWithFileByActive(pid){
      let postData = new FormData();
      postData.append("pid",pid);
      return this.http.post<Response>(this.serviceUrl.host+this.serviceUrl.getAllPostWithFileDetails+"/"+pid,postData);
    }
    
    getMediaDataByType(typeId){
      let headers = new HttpHeaders();

      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
      let postData = new FormData();
      postData.append("mediatype",typeId);
      return this.http.post<Response>(this.serviceUrl.host+this.serviceUrl.getMediaDataByType,postData,{headers:headers});
    }

    getMediaTypes(){
      return this.http.get<Response>(this.serviceUrl.host+this.serviceUrl.getMediaTypes);
    }


    postByUploadId(fileToUpload) {
      debugger
     
      let uploads = new FormData();
      uploads.append("fileUploadId",fileToUpload);
   
      let headers = new HttpHeaders();

      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());
      
      return this.http.post(this.serviceUrl.host+this.serviceUrl.postPublishByUploadId,uploads,{headers:headers});
  }
}
