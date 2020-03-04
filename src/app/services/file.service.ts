import { Injectable } from '@angular/core';

import { v4 } from 'uuid';
import { FileElement } from '../models/file-explorer';
import { Observable, BehaviorSubject } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { ServiceUrlService} from '../serviceUrl/service-url.service';
import { AuthenticationService } from './authentication.service';
import { Response } from '../models/post';
export interface IFileService {
  add(fileElement: FileElement);
  delete(id: string);
  update(id: string, update: Partial<FileElement>);
  queryInFolder(folderId: string): Observable<FileElement[]>;
  get(id: string): FileElement;
}

@Injectable()
export class FileService implements IFileService {
  private map = new Map<string, FileElement>();

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService,private authenticationService: AuthenticationService) {}

  add(fileElement: FileElement) {
    debugger
    fileElement.fid = v4();
    this.map.set(fileElement.fid, this.clone(fileElement));
    return fileElement;
  }

  addSubscribe(fileElement: FileElement){
    debugger
    this.map.set(fileElement.fid, this.clone(fileElement));
    return fileElement;
  }

  delete(id: string) {
    this.map.delete(id);
  }

  getFilesAndFolders(){
    return this.http.get<FileElement[]>(this.serviceUrl.host+this.serviceUrl.getFilesAndFolders);
  }

  addFilesAndFolders(fid,name,isFolder,parent){
    debugger
    let fileFolderData = new FormData();
    fileFolderData.append("fid",fid);
    fileFolderData.append("name",name);
    fileFolderData.append("isFolder",isFolder);
    fileFolderData.append("parent",parent);
    return this.http.post<Response>(this.serviceUrl.host+this.serviceUrl.addFileAndFolders,fileFolderData);
  }

  update(id: string, update: Partial<FileElement>) {
    let element = this.map.get(id);
    element = Object.assign(element, update);
    this.map.set(element.fid, element);
  }

  private querySubject: BehaviorSubject<FileElement[]>;
  queryInFolder(folderId: string) {
    debugger
    const result: FileElement[] = [];
    this.map.forEach(element => {
      if (element.parent === folderId) {
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

  get(id: string) {
    return this.map.get(id);
  }

  clone(element: FileElement) {
    return JSON.parse(JSON.stringify(element));
  }

  getFilesAndFoldersById(fid){
    return this.http.get(this.serviceUrl.host+this.serviceUrl.getFilesAndFoldersByid+"/"+fid);
  }
}
