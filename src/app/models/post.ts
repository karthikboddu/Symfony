export class Post {
    u_id: number
    u_name: string
    u_surname: string
    u_username: string
    u_email: string
    u_password: string
    u_roles: Array<string>
    u_created_at: string
    u_phonenumber: number
    u_accountstatus: Array<string>
    u_active: boolean
    pu_id: number
    pu_name: string
    pu_description: string
    pu_created: string
    pu_posturl: string
    pu_status: boolean
    pt_id: number
    pt_name: string
    pt_created: string
    pf_id: number
    pf_file: string
    pf_uploaded_at: string
    pf_fileName: string
    pf_etag: string
    pf_imageUrl: any
}