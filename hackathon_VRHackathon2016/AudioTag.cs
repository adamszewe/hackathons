
using System;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using Parse;
using UnityEngine;

public class AudioTag : MonoBehaviour
{

    /** * The maximum length of the audio file */ 
    public const int MAX_AUDIO_FILE_LENGTH = 20;

    // source for the sound stream
    private AudioSource audioSource;

    /// an auxiliary flag to check if we are in the process of recording something
    private bool isRecording = false;

    private System.Collections.Generic.List<TAG> allTags = new System.Collections.Generic.List<TAG>(); 

	// Use this for initialization
	void Start () {
	        Debug.Log("AudioTag script initialized");
//            audioSource = this.GetComponent<AudioSource>();



	}
	
	// Update is called once per frame
	void Update () {

	    if (Input.GetMouseButtonDown(0))    // button 2 is the middle button
	    {
//            saveTag(33, 66, 99, "Assets/audiotag.wav");
            getAllTags();
            Debug.Log("got all tags");
	    }

	    if (Input.GetMouseButtonDown(1))
	    {
            printAllTags();
	    }  
	}



    /**
     * Print all the tags
     */
    public void printAllTags()
    {
        Debug.Log("printing all tags");
        foreach (TAG t in allTags)
        {
            Debug.Log("id: " + t.id + " x: " + t.x);
        }
    }
    


    IEnumerator saveRecordingOnDisk()
    {
        SavWav.Save("audiotag.wav", audioSource.clip);
        yield return null;
    }

    IEnumerator recordAudio()
    {

        if (Microphone.IsRecording(null))
        {
            Microphone.End(null);
            isRecording = false;
        }
        else
        {
            // if we are not recording, then we start to do so
            isRecording = true;
            audioSource.clip = Microphone.Start(null, true, MAX_AUDIO_FILE_LENGTH, 44100);
            yield return new WaitForSeconds(MAX_AUDIO_FILE_LENGTH);
            stopRecording();
        }
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





    /**
     * If the microphone is recording, then we stop the process and save the audio clip.
     */
    void stopRecording()
    {
        if (isRecording)
        {
            Microphone.End(null); //Stop the audio recording  
            StartCoroutine(saveRecordingOnDisk());
            isRecording = false;
        }
    }




    /* using parse library to save the data in cloud */
    public void saveTag(float x, float y, float z, string filePath) 
    {
        var audioTag = new ParseObject("customclass");
        byte[] fileWAV = readBinaryFile(filePath);

        ParseFile file = new ParseFile("temporaryparsefile.wav", fileWAV);
        audioTag["fileWAV"] = file;
        audioTag["x"] = x;
        audioTag["y"] = y;
        audioTag["z"] = z;
        audioTag.SaveAsync();

        // todo update the list of available tags
    }



    //    public void getAllTags()
    //    {
    //        var query = ParseObject.GetQuery("customclass");
    //
    //        List<TAG> allTags = new List<TAG>();
    //        query.FindAsync().ContinueWith(t =>
    //        {
    //            Debug.Log("Inside the method Loop");
    //            IEnumerable<ParseObject> results = t.Result;
    //            foreach (ParseObject po in results)
    //            {
    //                float x = po.Get<float>("x");
    //                float y = po.Get<float>("y");
    //                float z = po.Get<float>("z");
    //                TAG aTAG = new TAG(po.ObjectId,  x, y, z);
    //            }
    //            this.allTags = allTags;
    //            Debug.Log("size : " + this.allTags.Count);
    //        });
    //    }






//    public void getAllTags()
//    {
//        var query = ParseObject.GetQuery("customclass");
//        query.FindAsync().ContinueWith(t =>
//        {
//            IEnumerable<ParseObject> results = t.Result;
//
//            Debug.Log("size: " + results.Count() );
//        });
//
//
//
//    }


    public void getAllTags()
    {
        var query = ParseObject.GetQuery("customclass");
        query.FindAsync().ContinueWith(t =>
        {
            IEnumerable<ParseObject> results = t.Result;

            Debug.Log("size: " + results.Count() );

            // clear the list
            this.allTags = new List<TAG>();

            foreach (ParseObject po in results)
            {
                float x = po.Get<float>("x");
                float y = po.Get<float>("y");
                float z = po.Get<float>("z");
                TAG aTAG = new TAG(po.ObjectId,  x, y, z);
                Debug.Log("id: " + aTAG.id);
                this.allTags.Add(aTAG);
            }
            Debug.Log("size of alltags: " + this.allTags.Count() );
        });
    }








    /**
     * A class that represents the TAG object that is composed of its unique id and
     * the three coordinates in the physical space.
     */ 
    public class TAG
    {
        public string id;
        public float x;
        public float y;
        public float z;

        public TAG(string id, float x, float y, float z)
        {
            this.id = id;
            this.x = x;
            this.y = y;
            this.z = z;
        }
    }








}
