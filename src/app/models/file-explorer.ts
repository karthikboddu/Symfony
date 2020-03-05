

export class FileElement {
    id : string;
    fid?: string;
    isfolder: boolean;
    name: string;
    parent: string;
  }
  
export class folderDetail {
    id : string;
    fid?: string;
    isfolder: boolean;
    name: string;
    parent: string;
}  
export class FileResponse{
    data : FileElement;
    status : any;
    message : any;
}

export class fileUploadDetails {
    userDetails : Array<user>
    uploadDetails : Array<fileUpload>
    folderDetails : Array<folderDetail>
}

export class fileUpload{
    id : number
    file : string
    uploadedAt : string
    fileName :  string
    etag : string
    image_url : string
    status :boolean
    fut_id : number
    fut_name :string
    fut_mediatype : string
    fut_createdAt : string
}
export class fileUploadType{
    id : number
    name :string
    mediatype : string
    createdAt : string
}
export class user{
    id : number
    name : string
    surname :string
    email : string
    phonenumber:number
    password : string
    role : any
    createdAt : string
    accontstatus : any
    active : boolean
}