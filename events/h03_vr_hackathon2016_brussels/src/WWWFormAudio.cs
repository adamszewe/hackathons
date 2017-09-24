using UnityEngine;
using System.Collections;
using System.IO;

public class WWWFormAudio : MonoBehaviour {

//    public const string UPLOAD_URL = "http://requestb.in/1bjeame1";
//    public const string UPLOAD_URL = "10.40.1.39:8888/22/comments";
    public const string UPLOAD_URL = "adam.liferunsonco.de/upload.php";

	// Use this for initialization
	void Start () {
        StartCoroutine(uploadWAV());
	}


    public static byte[] readBinaryFile(string filePath)
    {
        byte[] fileData;
            fileData = File.ReadAllBytes(filePath);
//        if (File.Exists(filePath))
//        {
//            fileData = File.ReadAllBytes(filePath);
//        }
        return fileData;
    }

    IEnumerator uploadWAV()
    {
        
        WWWForm form = new WWWForm();
        form.AddField("counter", 1872);

        Debug.Log("starting upload");
        // todo read the file in binary
        
        

        form.AddBinaryData("fileToUpload", readBinaryFile("Assets/audiotag.wav"), "fileToUpload", "multipart/form-data");

        // todo get the user's position
        form.AddField("position", "23234,23423,444");
        
        // Upload to a cgi script
        WWW w = new WWW(UPLOAD_URL, form);
        yield return w;
        if (!string.IsNullOrEmpty(w.error))
        {
            print(w.error);
        }
        else {
            print("Finished Uploading Screenshot");
        }
    }
    
}


