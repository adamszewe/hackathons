using UnityEngine;
using System.Collections;
using Parse;
using System.IO;
using System.Threading.Tasks;

public class ParseTest : MonoBehaviour {

	// Use this for initialization
	void Start () {
        ParseObject testObject = new ParseObject("TestInParse");
        testObject["foo"] = "it works!";
        testObject.SaveAsync();
        Debug.Log("parse object saved");

        // sending file 
	    byte[] audioFile = File.ReadAllBytes("Assets/audiotag.wav");

        ParseFile parseFile = new ParseFile("parsefile.wav", audioFile);

//	    Task saveTask = parseFile.SaveAsync();

        var jobApplication = new ParseObject("JobApplication");

        jobApplication["isthisthekey"] = "Joe Smith";
        jobApplication["filetosave"] = parseFile;
        Task saveTask = jobApplication.SaveAsync();


        Debug.Log("parse file saved");



        //	    FileStream audioFile = File.Open("Assets/audiotag.wav", FileMode.Open);

    }
	
	// Update is called once per frame
	void Update () {
	
	}



    /**
     * Given a path to file, the file is read in binary mode and returned as an array of bytes.
     */
    public static byte[] readBinaryFile(string filePath)
    {
        byte[] fileData;
        fileData = File.ReadAllBytes(filePath);
        return fileData;
    }
}
