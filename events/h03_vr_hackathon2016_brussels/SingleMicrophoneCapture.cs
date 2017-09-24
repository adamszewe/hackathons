

/*
    there is a fixed amount of time for a sound message - when the recording exceeds that time, then the message is saved as is 
    
    the recording can be interrupted with a click of the button, so we won't waste any time/space/bandwidth 
    if the user choses to record a shorter message 


*/

using UnityEngine;
using System.Collections;


[RequireComponent(typeof(AudioSource))]

public class SingleMicrophoneCapture : MonoBehaviour
{

    private const int AUDIO_FILE_LENGHT = 30;

    //A boolean that flags whether there's a connected microphone  
    private bool micConnected = false;

    //The maximum and minimum available recording frequencies  
    private int minFreq;
    private int maxFreq;

    //A handle to the attached AudioSource  
    private AudioSource goAudioSource;

    //save audio
    SavWav savWav;

    //upload
    public string uploadDataURL;
    string sessionName;

    //Use this for initialization  
    void Start()
    {
        sessionName = "session_date_" + System.DateTime.Now.Day + "-" + System.DateTime.Now.Month + "-" + System.DateTime.Now.Year + "_time_" + System.DateTime.Now.Hour + "-" + System.DateTime.Now.Minute + "-" + System.DateTime.Now.Second;
        savWav = GetComponent<SavWav>();

        //Check if there is at least one microphone connected  
        if (Microphone.devices.Length <= 0)
        {
            //Throw a warning message at the console if there isn't  
            Debug.LogWarning("Microphone not connected!");
        }
        else //At least one microphone is present  
        {
            //Set 'micConnected' to true  
            micConnected = true;

            //Get the default microphone recording capabilities  
            Microphone.GetDeviceCaps(null, out minFreq, out maxFreq);

            //According to the documentation, if minFreq and maxFreq are zero, the microphone supports any frequency...  
            if (minFreq == 0 && maxFreq == 0)
            {
                //...meaning 44100 Hz can be used as the recording sampling rate  
                maxFreq = 44100;
            }

            //Get the attached AudioSource component  
            goAudioSource = this.GetComponent<AudioSource>();
        }

        StartCoroutine(recordAudio());

    }





    IEnumerator recordAudio()
    {
        //If there is a microphone  
        if (micConnected)
        {
            //If the audio from any microphone isn't being captured  
            if (!Microphone.IsRecording(null))
            {
                //Case the 'Record' button gets pressed  
                //if (GUI.Button(new Rect(Screen.width / 2 - 100, Screen.height / 2 - 25, 200, 50), "Record"))
                //{
                //Start recording and store the audio captured from the microphone at the AudioClip in the AudioSource  
                goAudioSource.clip = Microphone.Start(null, true, AUDIO_FILE_LENGHT, maxFreq);
                yield return new WaitForSeconds(1f);

                StartCoroutine(saveRecordingOnDisk());
                Microphone.End(null); //Stop the audio recording  
//                goAudioSource.Play(); //Playback the recorded audio  
                //}
            }
            else //Recording is in progress  
            {
                //Case the 'Stop and Play' button gets pressed  
                //if (GUI.Button(new Rect(Screen.width / 2 - 100, Screen.height / 2 - 25, 200, 50), "Stop and Play!"))
                //{
                    Microphone.End(null); //Stop the audio recording  
 //                   goAudioSource.Play(); //Playback the recorded audio  
                //}

                //GUI.Label(new Rect(Screen.width / 2 - 100, Screen.height / 2 + 25, 200, 50), "Recording in progress...");
            }
        }
        else // No microphone  
        {
            //Print a red "Microphone not connected!" message at the center of the screen  
            //GUI.contentColor = Color.red;
            //GUI.Label(new Rect(Screen.width / 2 - 100, Screen.height / 2 - 25, 200, 50), "Microphone not connected!");
        }
    }

    IEnumerator saveRecordingOnDisk()
    {
        SavWav.Save("time_recording" , goAudioSource.clip);
        yield return null;
    }

    IEnumerator uploadDataToWeb()
    {
        Debug.Log("start saving");
//        SavWav.Save("time_" + System.DateTime.Now.Hour + "-" + System.DateTime.Now.Minute + "-" + System.DateTime.Now.Second, goAudioSource.clip);
        Debug.Log("stop saving");

        yield return new WaitForSeconds(0.5f);

        //Debug.Log(comment);

        WWWForm form = new WWWForm();
        form.AddField("session", sessionName);
        byte[] binary = System.Text.Encoding.Unicode.GetBytes("bar");
        form.AddBinaryData("comment", binary, "test.txt", "application/octet-stream");

        ///         WWWClient http = new WWWClient(this, "http://example.com/");
        ///         client.AddBinaryData("foo", binary, "test.txt", "application/octet-stream");
        ///         client.OnDone = (WWW www) => {
        ///             Debug.Log(www.text);
        ///         };
        ///         client.Request();

        // Upload to a cgi script
        WWW w = new WWW(uploadDataURL, form);
        yield return w;
        if (!string.IsNullOrEmpty(w.error))
        {
            print(w.error);

            Handheld.Vibrate();
            yield return new WaitForSeconds(0.5f);
            Handheld.Vibrate();
            yield return new WaitForSeconds(0.5f);
            Handheld.Vibrate();
        }
        else
        {
            print("Finished Uploading Data: ");

            Handheld.Vibrate();
        }
            
    }
}
