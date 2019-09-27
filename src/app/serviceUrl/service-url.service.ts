import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ServiceUrlService {

  constructor() { }
  public host = environment.baseUrl;
  public register = '/api/register';
  public login = '/api/token';
  public post = '/api/post';
  public posts = '/api/posts';
  public postid = '/api/postById';
  public tags = '/api/tags';
  public postByTag = '/api/postByTag';
  public upload = '/api/upload';
  public singlePost = '/api/viewPostByUser';
}
