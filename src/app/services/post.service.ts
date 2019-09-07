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
      let headers_object = new HttpHeaders().set(
        "Authorization",
        'Bearer ${this.authenticationService.getToken()}'
      );
      
        return this.http.post(this.serviceUrl.host+this.serviceUrl.postid,{headers: headers_object});
    }

    post(post: Post) {
        debugger
        let registerpost = new FormData();
        registerpost.append("title",post.title);
        registerpost.append("description",post.description);
        let headers_object = new HttpHeaders().set(
          "Authorization",
          this.authenticationService.getToken()
        );
        return this.http.post(this.serviceUrl.host+this.serviceUrl.post, registerpost,{headers:headers_object});
    }

    update(post: Post) {
        return this.http.put(`/users/` + post.id, post);
    }

    delete(id: number) {
        return this.http.delete(`/posts/` + id);
    }

}
