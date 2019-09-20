import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
import { Post } from '../models/post';
import { AuthenticationService } from './authentication.service';

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

    post(post: Post) {
        debugger
        let registerpost = new FormData();
        registerpost.append("name",post.name);
        let headers = new HttpHeaders({ 'Content-Type': 'application/json' });

        headers = headers.append('Authorization', 'Bearer ' + this.authenticationService.getToken());
        registerpost.append("description",post.description);
        
        return this.http.post(this.serviceUrl.host+this.serviceUrl.post, post,{headers:headers});
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

}
