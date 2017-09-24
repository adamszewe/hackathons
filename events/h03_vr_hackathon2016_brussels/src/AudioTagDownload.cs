using UnityEngine;
using System.Collections;
using System.IO;

public class AudioTagDownload : MonoBehaviour {

//    public string url = "http://mp3.stream.tb-group.fm/tb.mp3";
    public string url = "http://www.externalharddrive.com/waves/animal/bird.wav";

    private AudioSource audioSource;

	// Use this for initialization
    void Start()
    {
        // nothing
    }

    public IEnumerator streamAudio(string url)
    {
        WWW www = new WWW(url);
        yield return www;

        AudioClip clip = www.audioClip;
        while (clip.loadState != AudioDataLoadState.Loaded)
            yield return null;

        clip = www.GetAudioClip(true, false, AudioType.WAV);

        audioSource = GetComponent<AudioSource>();
        audioSource.clip = clip;
        audioSource.Play();
    }


	
	void Update () {
	    if (Input.GetMouseButtonDown(2))
	    {
	        StartCoroutine(streamAudio(url));
	    }
	}
}
