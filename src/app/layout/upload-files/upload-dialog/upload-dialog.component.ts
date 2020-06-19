import { Component, OnInit,Input, Output, EventEmitter, ViewChild } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';
import { UploadService } from './../upload.service';
import { forkJoin } from 'rxjs';
import { first } from 'rxjs/operators';
import { FileElement } from 'src/app/models/file-explorer';
import { DataSource } from '@angular/cdk/collections';
@Component({
  selector: 'app-upload-dialog',
  templateUrl: './upload-dialog.component.html',
  styleUrls: ['./upload-dialog.component.scss']
})
export class UploadDialogComponent implements OnInit {

  @ViewChild('file') file;

  public files: Set<File> = new Set();
  @Output() fileAdded = new EventEmitter<{ name: string }>();
  constructor(public dialogRef: MatDialogRef<UploadDialogComponent>, public uploadService: UploadService) { }
  fileName:FileList;
  ngOnInit() { }

  progress;
  canBeClosed = true;
  primaryButtonText = 'Upload';
  showCancelButton = true;
  uploading = false;
  uploadSuccessful = false;
  currentRoot: FileElement;
  onFilesAdded() {
    debugger
    const files: { [key: string]: File } = this.file.nativeElement.files;
    console.log(files,"files");
    for (let key in files) {
      if (!isNaN(parseInt(key))) {
        this.files.add(files[key]);
      }
    }
  }

  addFiles() {
    debugger
    this.file.nativeElement.click();
  }

  closeDialog() {
    debugger
    // if everything was uploaded already, just close the dialog
    if (this.uploadSuccessful) {
       return this.dialogRef.close({name:this.fileName});
    }
    //this.fileName = this.file.nativeElement.files;
    // set the component state to "uploading"
    this.uploading = true;

    // start the upload and save the progress map
   this.progress = this.uploadService.upload(this.files);
     //this.uploadService.videoUpload(this.files);

    console.log(this.progress);
    for (const key in this.progress) {
      this.progress[key].progress.subscribe(val => console.log(val));
    }

    // convert the progress map into an array
    let allProgressObservables = [];
    for (let key in this.progress) {
      allProgressObservables.push(this.progress[key].progress);
    }

    // Adjust the state variables

    // The OK-button should have the text "Finish" now
    this.primaryButtonText = 'Finish';

    // The dialog should not be closed while uploading
    this.canBeClosed = false;
    this.dialogRef.disableClose = true;

    // Hide the cancel-button
    this.showCancelButton = false;

    // When all progress-observables are completed...
    forkJoin(allProgressObservables).subscribe(end => {
      // ... the dialog can be closed again...
      this.canBeClosed = true;
      this.dialogRef.disableClose = false;

      // ... the upload was successful...
      this.uploadSuccessful = true;

      // ... and the component is no longer uploading
      this.uploading = false;
    });
  }

}
