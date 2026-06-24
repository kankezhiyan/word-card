(function () {
    'use strict';

    const target = document.documentElement;
    const colorStorageKey = 'user-theme-scheme';
    const targetAttributeName = 'data-theme-scheme';

    const colorModList = {
        'auto': true, 'day': true, 'sunset': true, 'night': true, 'moonlight': true, 'lowlight': true
    };

    const toggleStatement = {
        'auto': 'moonlight', 'day': 'moonlight', 'sunset': 'moonlight', 'night': 'moonlight', 'moonlight': 'auto', 'lowlight': 'auto'
    };

    const toggleSwitch = {
        'auto': 'moonlight', 'moonlight': 'auto'
    };

    const themeButtonStatement = {
        'auto': '1', 'day': '2', 'sunset': '3', 'night': '4', 'moonlight': '5', 'lowlight': '6'
    };

    const themeButtonEvent = {
        '1': 'auto', '2': 'day', '3': 'sunset', '4': 'night', '5': 'moonlight', '6': 'lowlight'
    };

    // 设置本地存储数据
    const siteLocStorage = (key, value) => {
        try {
            localStorage.setItem(key, value);
        } catch (e) {
            console.warn('LocalStorage set failed:', e);
        }
    };

    // 清除本地存储数据
    const removeLocStorage = (key) => {
        try {
            localStorage.removeItem(key);
        } catch (e) {
            console.warn('LocalStorage remove failed:', e);
        }
    };

    // 获取本地存储数据
    const getLocStorage = (key) => {
        try {
            return localStorage.getItem(key);
        } catch (e) {
            console.warn('LocalStorage get failed:', e);
            return null;
        }
    };

    // 获取系统主题设置
    const getMQMod = () => {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme:dark)').matches ? 'moonlight' : 'auto';
    };

    // 时间设定
    const siteAutoTheme = () => {
        let timeOnLoad = WordCard.getTimeInNeed('hour')

        if (timeOnLoad >= 5 && timeOnLoad < 15) { return 'day' }
        else if (timeOnLoad >= 15 && timeOnLoad < 18) { return 'sunset' }
        else if (timeOnLoad >= 18 && timeOnLoad < 23) { return 'night' }
        else { return 'moonlight' }
    }

    // 重置主题属性
    const resetModAttribute = () => {
        target.setAttribute(targetAttributeName, siteAutoTheme());
        siteLocStorage(colorStorageKey, 'auto');
    };

    // 写入主题属性
    const writeModAttribute = (value) => {
        if (value === 'auto') {
            target.setAttribute(targetAttributeName, siteAutoTheme());
        } else {
            target.setAttribute(targetAttributeName, value);
        }
        siteLocStorage(colorStorageKey, value);
    };

    // 用户主题设置
    const userModSitting = (mod) => {
        let siteMod = mod || getLocStorage(colorStorageKey);
        let mediaMod = getMQMod();

        if (siteMod === mediaMod) {
            writeModAttribute(mediaMod);
        } else if (colorModList[siteMod]) {
            writeModAttribute(siteMod);
        } else if (siteMod === null) {
            writeModAttribute(mediaMod);
        } else {
            resetModAttribute();
        }
    };

    // 获取切换后的主题
    const toggleModSitting = () => {
        let sitetoggle = getLocStorage(colorStorageKey);

        if (colorModList[sitetoggle]) {
            sitetoggle = toggleStatement[sitetoggle];
        } else if (sitetoggle === null) {
            sitetoggle = toggleStatement[getMQMod()];
        } else {
            sitetoggle = toggleStatement['auto'];
        }

        return sitetoggle;
    };

    // 获取当前主题对应的按钮索引
    const themeModSitting = () => {
        let sitetheme = getLocStorage(colorStorageKey);
        if (colorModList[sitetheme]) {
            sitetheme = themeButtonStatement[sitetheme];
        } else if (sitetheme === null) {
            sitetheme = themeButtonStatement[getMQMod()];
        } else {
            sitetheme = themeButtonStatement['auto'];
        }

        return sitetheme;
    };

    // 切换显示/隐藏主题按钮
    const toggleModSwitch = (mod) => {
        let theme = mod || toggleModSitting();
        let showButton = document.getElementById(theme + '-mod');
        let hideButton = document.getElementById(toggleSwitch[theme] + '-mod');

        if (showButton) {
            showButton.style.display = 'flex';
        }
        if (hideButton) {
            hideButton.style.display = 'none';
        }
    };

    // 激活当前主题在列表中的状态
    const themeListSite = (mod) => {
        let theme = mod || themeModSitting();
        let floatMod = document.getElementById('theme-' + theme);
        if (floatMod) {
            floatMod.classList.add('theme-be-actived');
        }
    };

    // 清除所有主题列表的激活状态
    const themeListClean = (list) => {
        if (!list) return;
        list.forEach((item) => {
            item.classList.remove('theme-be-actived');
        });
    };

    // 绑定主题列表点击事件
    const themeListSwitch = () => {
        let floatList = document.querySelectorAll('.theme-box li');

        floatList.forEach((item, key) => {
            item.setAttribute('data-value', ++key);
            item.addEventListener('click', () => {
                themeListClean(floatList);
                themeListSite(key);
                userModSitting(themeButtonEvent[key]);
                toggleModSwitch(toggleStatement[themeButtonEvent[key]]);
            });
        });
    };

    // 绑定快捷主题切换按钮事件
    const shortTheme = document.getElementById('mod-button');
    if (shortTheme) {
        shortTheme.addEventListener('click', () => {
            let theme = toggleModSitting();
            let floatList = document.querySelectorAll('.theme-box li');
            userModSitting(theme);
            themeListClean(floatList);
            themeListSite(themeButtonStatement[theme]);
            toggleModSwitch();
        });
    }

    // 初始化主题
    userModSitting();
    toggleModSwitch();
    themeListSite();
    themeListSwitch();
})();