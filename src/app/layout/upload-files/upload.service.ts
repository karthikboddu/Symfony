import { Injectable } from '@angular/core';
import { Observable, Subject, BehaviorSubject } from 'rxjs';
import { HttpClient, HttpRequest, HttpEventType, HttpResponse, HttpHeaders } from '@angular/common/http';
import { AuthenticationService } from './../../services/authentication.service';
import { ServiceUrlService } from '../../serviceUrl/service-url.service';
import { UploadElement } from '../../models/upload-element';
import { v4 } from 'uuid';
import { FileElement, FileResponse } from '../../models/file-explorer';


@Injectable()
export class UploadService {
  constructor(private http: HttpClient, private authenticationService: AuthenticationService, private serviceUrl: ServiceUrlService) { }
  fileName;
  private map = new Map<string, FileElement>();
  private filemap = new Map<string,File>();
  userFileUploadId: BehaviorSubject<Array<any>> = new BehaviorSubject([]);
  currentRoot: FileElement;
  userFileData = this.userFileUploadId.asObservable();
  public upload(files: Set<File>): { [key: string]: { progress: Observable<number> } } {
    // this will be the our resulting map
     let resultId = [];
    const status: { [key: string]: { progress: Observable<number> } } = {};
    //const res :{ [key:string]: {result: resultId  } } = {};
    files.forEach(file => {
      this.fileName = file['name'];
      // create a new multipart-form for every file
      const formData: FormData = new FormData();
      formData.append('file', file);
      formData.append('fileName', this.fileName);
      let headers = new HttpHeaders();

      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());

      // const req =  this.http.post<any>(this.serviceUrl.host+this.serviceUrl.upload,formData,{headers:headers});
      // create a http-post request and pass the form
      // tell it to report the upload progress

      const req = new HttpRequest('POST', this.serviceUrl.host + this.serviceUrl.upload, formData, {
        reportProgress: true, headers
      });

      // create a new progress-subject for every file
      const progress = new Subject<number>();

      // send the http-request and subscribe for progress-updates

      const startTime = new Date().getTime();
      this.http.request(req).subscribe((event: any) => {
        if(isNaN(event.body)){
        
        }else{
          resultId.push(event.body);
          console.log(event.body,"event");  
        }
        

        // this.userFileUploadId.next(resultId);
        // this.add(file);
        // console.log("resultid", resultId);
        if (event.type === HttpEventType.UploadProgress) {
          // calculate the progress percentage

          const percentDone = Math.round((100 * event.loaded) / event.total);
          // pass the percentage into the progress-stream
          progress.next(percentDone);
        } else if (event instanceof HttpResponse) {
          // Close the progress-stream if we get an answer form the API
          // The upload is complete
          progress.complete();
        }
      });

      // Save every progress-observable in a map of all observables
      status[file.name] = {
        progress: progress.asObservable()
      };
    });

    // return the map of progress.observables
    return status;
  }


  videoUpload(files: Set<File>): { [key: string]: { progress: Observable<number> } } {
    const status: { [key: string]: { progress: Observable<number> } } = {};
    files.forEach(file => {
      debugger
      const formData: FormData = new FormData();
      formData.append('file', file);
      let headers = new HttpHeaders();

      headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());

      this.http.post<any>(this.serviceUrl.host + this.serviceUrl.upload, formData, { headers: headers }).subscribe(
        data => {

          //this.allImg = data[0]['postfile'];
          console.log("data", data);
          //console.log("imgdata",data['postfile']);
        },
        error => {
          console.log("errors", error);
        });
      // create a http-post request and pass the form
      // tell it to report the upload progress




    });
    return status;
  }

  getFileUpload() {
    let headers = new HttpHeaders();
    headers = headers.append('X-Custom-Auth', 'Bearer ' + this.authenticationService.getToken());

    return this.http.get(this.serviceUrl.host + this.serviceUrl.userFileUpload, { headers: headers });
  }
  ufuId;
  getUserFileUploadId() {
     return this.userFileUploadId.value;
  }

  unSubsUserFileUploadId(){
    this.userFileUploadId.unsubscribe();
  }

  add(uploadElement: File) {
    // uploadElement.
    this.filemap.set(uploadElement.name,uploadElement);
    console.log(this.filemap,"filemap");
    return uploadElement;
  }

  clone(element: UploadElement) {
    return JSON.parse(JSON.stringify(element));
  }


  private querySubject: BehaviorSubject<File[]>;
  queryInFolder() {

    const result: File[] = [];
    this.filemap.forEach(element => {

        result.push(element);

    });
    if (!this.querySubject) {
      this.querySubject = new BehaviorSubject(result);
    } else {
      this.querySubject.next(result);
    }
    return this.querySubject.value;
  }

}