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
  public getAuth = '/api/check_login';
  public postsByHomeScreen = '/api/postsByHomeScreen';
  public isTokenValid = '/api/auth/isTokenValid';
  public adminUsers ='/api/users/fetchactiveusers';
  public adminTotalPostsActive = '/api/admin/totalPostsByActive';
  public adminTotalUsers = '/api/admin/getNumberUsers';
  public adminDeleteUsers = '/api/admin/deleteUser';
  public userFileUpload = '/api/postfileUpload';
  public allPostWithFileDetails = '/api/postGroupAll';
  public getFilesAndFolders = '/api/file/getFileExp';
  public getFilesAndFoldersByid = '/api/folderGroupAll';
  
  public addFileAndFolders = '/api/File/addFileExp';
}
