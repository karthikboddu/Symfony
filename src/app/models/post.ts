

export class Post {
    userDetails : Array<user>
    userpost
    uploadDetails : Array<fileUpload>
}
export class userpost{
    p_id : number
    name : string
    description :string
    post_url : string
    createdAt : string
    status : boolean
}

export class Response{
    data : Array<Post>
    status : any;
    message : any;
}


export class fileUpload{
    id : number
    file : string
    uploadedAt : string
    fileName :  string
    etag : string
    fileupload_imageUrl : string
    status :boolean
    fut_id : number
    fut_name :string
    fut_mediatype : string
    fut_createdAt : string
    futn_id: number
    futn_name : string;
    futn_createdAt :string;
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